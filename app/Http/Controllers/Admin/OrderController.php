<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function orderList()
    {
        // direct order page
        if (Session::has('ORDER_SEARCH')) {
            Session::forget('ORDER_SEARCH');
        }
        $data = Order::select('orders.*', 'users.name as customer_name', 'pizzas.pizza_name')
            ->selectRaw('Count(orders.pizza_id) as quantity')
            ->join('users', 'users.id', 'orders.customer_id')
            ->join('pizzas', 'pizzas.pizza_id', 'orders.pizza_id')
            ->groupBy('orders.customer_id', 'orders.pizza_id')
            ->paginate(7);
        return view('admin.order.order')->with(['orders' => $data]);
    }

    public function searchOrder(Request $request)
    {
        $data = Order::select('orders.*', 'users.name as customer_name', 'pizzas.pizza_name')
            ->selectRaw('Count(orders.pizza_id) as quantity')
            ->join('users', 'users.id', 'orders.customer_id')
            ->join('pizzas', 'pizzas.pizza_id', 'orders.pizza_id')
            ->orwhere('users.name', 'like', '%' . $request->search . '%')
            ->orwhere('pizzas.pizza_name', 'like', '%' . $request->search . '%')
            ->groupBy('orders.customer_id', 'orders.pizza_id')
            ->paginate(7);
        Session::put('ORDER_SEARCH', $request->search);
        $data->appends($request->all());
        return view('admin.order.order')->with(['orders' => $data]);
    }

    // order list download
    public function orderDownload()
    {
        if (Session::has('ORDER_SEARCH')) {
            $order = Order::select('orders.*', 'users.name as customer_name', 'pizzas.pizza_name')
                ->selectRaw('Count(orders.pizza_id) as quantity')
                ->join('users', 'users.id', 'orders.customer_id')
                ->join('pizzas', 'pizzas.pizza_id', 'orders.pizza_id')
                ->orwhere('users.name', 'like', '%' . Session::get('ORDER_SEARCH') . '%')
                ->orwhere('pizzas.pizza_name', 'like', '%' . Session::get('ORDER_SEARCH') . '%')
                ->groupBy('orders.customer_id', 'orders.pizza_id')
                ->get();
        } else {
            $order = Order::select('orders.*', 'users.name as customer_name', 'pizzas.pizza_name')
                ->selectRaw('Count(orders.pizza_id) as quantity')
                ->join('users', 'users.id', 'orders.customer_id')
                ->join('pizzas', 'pizzas.pizza_id', 'orders.pizza_id')
                ->groupBy('orders.customer_id', 'orders.pizza_id')
                ->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($order) {
            $order->created_at = $order->created_at->format('Y-m-d');
        });

        $csvExporter->build($order, [
            'order_id' => 'No',
            'customer_id' => 'Customer Id',
            'pizza_id' => 'Pizza Id',
            'payment_status' => 'Payment',
            'order_time' => 'Order Date',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'order_list.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

}
