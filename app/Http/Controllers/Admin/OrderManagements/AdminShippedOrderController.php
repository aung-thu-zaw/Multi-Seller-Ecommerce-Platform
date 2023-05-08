<?php

namespace App\Http\Controllers\Admin\OrderManagements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminShippedOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $shippedOrders=Order::search(request("search"))
                             ->where("status", "shipped")
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());


        return inertia("Admin/OrderManagements/ShippedOrders/Index", compact("shippedOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $shippedOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", auth()->user()->id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $shippedOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/ShippedOrders/Detail", compact("shippedOrderDetail", "deliveryInformation", "orderItems"));
    }

    // public function update(int $id): RedirectResponse
    // {
    //     Order::findOrFail($id)->update(["status"=>"shipped"]);

    //     return to_route("admin.orders.shipped.index")->with("success", "Order is shipped");
    // }
}
