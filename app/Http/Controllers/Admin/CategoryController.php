<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //direct category list page
    public function category()
    {
        if (Session::has('CATEGORY_SEARCH')) {
            Session::forget('CATEGORY_SEARCH');
        }
        $data = Category::select('categories.category_id', 'categories.category_name', DB::raw('Count(pizzas.category_id) as count'))
            ->leftjoin('pizzas', 'pizzas.category_id', 'categories.category_id')
            ->groupby('categories.category_id', 'categories.category_name')
            ->paginate(7);
        return view('admin.category.list')->with(['category' => $data]);
    }
    //direct add category page
    public function addCategory()
    {
        return view('admin.category.addCategory');
    }
    // create new category
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], ['name.required' => 'Category Name is required']);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = [
            'category_name' => $request->name,
        ];

        Category::create($data);
        return redirect()->route('admin#category')->with(['massage' => 'Category Added']);
    }
    // category delete
    public function deleteCategory($id)
    {
        Category::where('category_id', $id)->delete();
        return back()->with(['massage' => 'Category deleted!']);
    }
    // edit category
    public function editCategory($id)
    {
        $data = Category::where('category_id', $id)->first();
        return view('admin.category.editCategory')->with(['category' => $data]);
    }
    // update category
    public function updateCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], ['name.required' => 'Category Name is required']);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $updateData = [
            'category_name' => $request->name,
        ];
        Category::where('category_id', $request->id)->update($updateData);
        return redirect()->route('admin#category')->with(['massage' => 'Update Success']);
    }
    // serach category
    public function searchCategory(Request $request)
    {
        $data = Category::select('categories.category_id', 'categories.category_name', DB::raw('Count(pizzas.category_id) as count'))
            ->leftjoin('pizzas', 'pizzas.category_id', 'categories.category_id')
            ->where('categories.category_name', 'like', '%' . $request->searchData . '%')
            ->groupby('categories.category_id')
            ->paginate(7);
        $data->appends($request->all());
        Session::put('CATEGORY_SEARCH', $request->searchData);
        return view('admin.category.list')->with(['category' => $data]);
    }
    // category download CSV
    public function categoryDownloadCSV()
    {
        if (Session::has('CATEGORY_SEARCH')) {
            $category = Category::select('categories.category_id', 'categories.category_name', 'categories.created_at', 'categories.updated_at', DB::raw('Count(pizzas.category_id) as count'))
                ->leftjoin('pizzas', 'pizzas.category_id', 'categories.category_id')
                ->where('categories.category_name', 'like', '%' . Session::get('CATEGORY_SEARCH') . '%')
                ->groupby('categories.category_id')
                ->get();
        } else {
            $category = Category::select('categories.category_id', 'categories.category_name', 'categories.created_at', 'categories.updated_at', DB::raw('Count(pizzas.category_id) as count'))
                ->leftjoin('pizzas', 'pizzas.category_id', 'categories.category_id')
                ->groupby('categories.category_id')
                ->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($category) {
            $category->created_at = $category->created_at->format('Y-m-d');
        });

        $csvExporter->build($category, [
            'category_id' => 'ID',
            'category_name' => 'Name',
            'count' => 'Product Count',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'category_list.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
