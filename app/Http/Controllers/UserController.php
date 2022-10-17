<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Pizza;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        $pizza = Pizza::where('public_status', 1)->paginate(9);
        $status = count($pizza) == 0 ? 0 : 1;
        $category = Category::get();
        return view('user.home')->with(['pizza' => $pizza, 'category' => $category, 'status' => $status]);
    }

    public function categorySearch($id)
    {
        $pizza = Pizza::where('category_id', $id)->paginate(9);
        $status = count($pizza) == 0 ? 0 : 1;
        $category = Category::get();
        return view('user.home')->with(['pizza' => $pizza, 'category' => $category, 'status' => $status]);
    }

    public function pizzaSearch(Request $request)
    {
        $pizza = Pizza::where('pizza_name', 'like', '%' . $request->serach . '%')->paginate(9);
        $pizza->appends($request->all());
        $status = count($pizza) == 0 ? 0 : 1;
        $category = Category::get();
        return view('user.home')->with(['pizza' => $pizza, 'category' => $category, 'status' => $status]);
    }

    public function pizzaSearchWithPrice(Request $request)
    {
        $minPrice = $request->minprice;
        $maxPrice = $request->maxprice;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $query = Pizza::select('*');
        if (!is_null($startDate) && is_null($endDate)) {
            $query = $query->whereDate('created_at', '>=', $startDate)->orderBy('created_at');
        } else if (is_null($startDate) && !is_null($endDate)) {
            $query = $query->whereDate('created_at', '<=', $endDate)->orderBy('created_at', 'desc');
        } else if (!is_null($startDate) && !is_null($endDate)) {
            $query = $query->where('created_at', '<=', $endDate)
                ->where('created_at', '>=', $startDate)->orderBy('price', 'desc');
        }
        if (!is_null($minPrice) && is_null($maxPrice)) {
            $query = $query->where('price', '>=', $minPrice)->orderBy('price');
        } else if (is_null($minPrice) && !is_null($maxPrice)) {
            $query = $query->where('price', '<=', $maxPrice)->orderBy('price', 'desc');
        } else if (!is_null($minPrice) && !is_null($maxPrice)) {
            $query = $query->where('price', '<=', $maxPrice)
                ->where('price', '>=', $minPrice)->orderBy('price', 'desc');
        }
        $query = $query->paginate(9);
        $query->appends($request->all());
        $status = count($query) == 0 ? 0 : 1;
        $category = Category::get();
        return view('user.home')->with(['pizza' => $query, 'category' => $category, 'status' => $status]);
    }

    // detail page
    public function pizzaDetailShowUser($id)
    {
        $data = Pizza::where('pizza_id', $id)->first();
        Session::put('PIZZA_INFO', $data);
        return view('user.detail')->with(['pizza' => $data]);
    }
    // order page
    public function order()
    {
        $pizzaInfo = Session::get('PIZZA_INFO');
        return view('user.order')->with(['pizza' => $pizzaInfo]);
    }
    // place order
    public function makeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pizzaCount' => 'required',
            'paymentType' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $pizzaInfo = Session::get('PIZZA_INFO');
        $userId = auth()->user()->id;
        $count = $request->pizzaCount;
        $orderData = $this->requestOrderData($pizzaInfo, $userId, $request);
        for ($i = 0; $i < $count; $i++) {
            Order::create($orderData);
        }
        $totalWaitingTime = $pizzaInfo['waiting_time'] * $count;
        return back()->with(['massage' => $totalWaitingTime]);
    }
    // private function categoryAndStatus()
    // {
    //     $status = count($pizza) == 0 ? 0 : 1;
    //     $category = Category::get();
    //     return view('user.home')->with(['pizza' => $pizza, 'category' => $category, 'status' => $status]);
    // }
    private function requestOrderData($pizzaInfo, $userId, $request)
    {
        return [
            'customer_id' => $userId,
            'pizza_id' => $pizzaInfo['pizza_id'],
            'carrier_id' => 0,
            'payment_status' => $request->paymentType,
            'order_time' => Carbon::now(),
        ];
    }
}
