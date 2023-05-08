<?php

namespace App\Http\Controllers\Admin\OrderManagements;

use App\Http\Controllers\Controller;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminPendingOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $pendingOrders=Order::search(request("search"))
                             ->where("status", "pending")
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());

        return inertia("Admin/OrderManagements/PendingOrders/Index", compact("pendingOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $pendingOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", auth()->user()->id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $pendingOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/PendingOrders/Detail", compact("pendingOrderDetail", "deliveryInformation", "orderItems"));
    }

    public function update(int $id): RedirectResponse
    {

        Order::findOrFail($id)->update(["status"=>"confirm"]);

        return to_route("admin.orders.confirmed.index")->with("success", "Order is confirmed");
    }
}
