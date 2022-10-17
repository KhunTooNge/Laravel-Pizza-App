<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Pizza;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller
{
    //direct pizza list page
    public function pizza()
    {
        if (Session::has('PIZZA_SEARCH')) {
            Session::forget('PIZZA_SEARCH');
        }
        $data = Pizza::paginate(3);
        if (count($data) == 0) {
            $emptyStatus = 0;
        } else {
            $emptyStatus = 1;
        }

        return view('admin.pizza.list')->with(['pizza' => $data, 'status' => $emptyStatus]);
    }
    // category item page
    public function categoryItem($id)
    {
        $data = Pizza::select('pizzas.*', 'categories.category_name')
            ->join('categories', 'pizzas.category_id', 'categories.category_id')
            ->where('pizzas.category_id', $id)
            ->paginate(5);
        return view('admin.category.item')->with(['pizza' => $data]);
    }
    // direct create pizza
    public function addPizza()
    {
        $category = Category::get();
        return view('admin.pizza.create')->with(['category' => $category]);
    }

    // create pizza & Insert pizza
    public function createPizza(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
            'price' => 'required',
            'publicStatus' => 'required',
            'category' => 'required',
            'discount' => 'required',
            'buyOneGetOne' => 'required',
            'waitingTime' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('image');
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $file->move(public_path() . '/uploads/', $fileName);

        $data = $this->requestPizzaData($request, $fileName);
        Pizza::create($data);
        return redirect()->route('admin#pizza')->with(['massage' => ' Add Pizza Successful']);
    }

    // remove record from pizza
    public function deletePizza($id)
    {
        $data = Pizza::select('image')->where('pizza_id', $id)->first();
        $fileName = $data['image'];
        // delete from file floder
        if (File::exists(public_path() . '/uploads/' . $fileName)) {
            File::delete(public_path() . '/uploads/' . $fileName);
        }
        Pizza::where('pizza_id', $id)->delete(); // db record delete
        return back()->with(['massage' => ' Pizza Record Deleted !']);
    }

    // receive data for update
    public function editPizza($id)
    {

        $category = Category::get();
        $data = Pizza::select('pizzas.*', 'categories.category_id', 'categories.category_name')
            ->join('categories', 'categories.category_id', 'pizzas.category_id')
            ->where('pizza_id', $id)
            ->first();
        return view('admin.pizza.editPizza')->with(['pizza' => $data, 'category' => $category]);
    }

    // pizza detail page
    public function detailPizza($id)
    {
        $data = Pizza::where('pizza_id', $id)->first();
        return view('admin.pizza.detail')->with(['pizza' => $data]);
    }

    // pizza update page
    public function updatePizza($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'publicStatus' => 'required',
            'category' => 'required',
            'discount' => 'required',
            'buyOneGetOne' => 'required',
            'waitingTime' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $updateData = $this->requestUpdateData($request);
        if (isset($updateData['image'])) {
            // get old image
            $data = Pizza::select('image')->where('pizza_id', $id)->first();
            $fileName = $data['image'];
            // delete old image.
            if (File::exists(public_path() . '/uploads/' . $fileName)) {
                File::delete(public_path() . '/uploads/' . $fileName);
            }
            // get new image from client
            $file = $request->file('image');
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . '/uploads/', $fileName);
            // update in server
            $updateData['image'] = $fileName;
        }

        Pizza::where('pizza_id', $id)->update($updateData);
        return redirect()->route('admin#pizza')->with(['massage' => 'Update data success!']);
    }
    // serach pizza
    public function serachPizza(Request $request)
    {
        $searchKey = $request->search;
        $searchData = Pizza::orWhere('pizza_name', 'like', '%' . $searchKey . '%')
            ->orWhere('price', 'like', '%' . $searchKey . '%')
            ->paginate(3);

        if (count($searchData) == 0) {
            $emptyStatus = 0;
        } else {
            $emptyStatus = 1;
        }
        Session::put('PIZZA_SEARCH', $searchKey);
        $searchData->appends($request->all());
        return view('admin.pizza.list')->with(['pizza' => $searchData, 'status' => $emptyStatus]);
    }

    // download pizza list
    public function pizzaDownload()
    {
        if (Session::has('PIZZA_SEARCH')) {
            $pizza = Pizza::orWhere('pizza_name', 'like', '%' . Session::get('PIZZA_SEARCH') . '%')
                ->orWhere('price', 'like', '%' . Session::get('PIZZA_SEARCH') . '%')
                ->get();
        } else {
            $pizza = Pizza::get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($pizza) {
            $pizza->created_at = $pizza->created_at->format('Y-m-d');
        });

        $csvExporter->build($pizza, [
            'pizza_id' => 'No',
            'pizza_name' => 'Name',
            'price' => 'Price',
            'image' => 'Image',
            'public_status' => 'Public',
            'category_id' => 'Category ID',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'pizza_list.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

    }

    // request update data from client
    private function requestUpdateData($request)
    {
        $arr = [
            'pizza_name' => $request->name,
            'price' => $request->price,
            'public_status' => $request->publicStatus,
            'category_id' => $request->category,
            'discount_price' => $request->discount,
            'buy_one_get_one_status' => $request->buyOneGetOne,
            'waiting_time' => $request->waitingTime,
            'description' => $request->description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        if (isset($request->image)) {
            $arr['image'] = $request->image;
        }
        return $arr;
    }
    // request client data
    private function requestPizzaData($request, $fileName)
    {
        return [
            'pizza_name' => $request->name,
            'image' => $fileName,
            'price' => $request->price,
            'public_status' => $request->publicStatus,
            'category_id' => $request->category,
            'discount_price' => $request->discount,
            'buy_one_get_one_status' => $request->buyOneGetOne,
            'waiting_time' => $request->waitingTime,
            'description' => $request->description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
