<?php

namespace App\Http\Controllers\Admin\OrderManagements\OrderManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\OrderItem;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminDeliveredOrderController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $deliveredOrders=Order::search(request("search"))
                              ->where("order_status", "delivered")
                              ->orderBy(request("sort", "id"), request("direction", "desc"))
                              ->paginate(request("per_page", 10))
                              ->appends(request()->all());

        return inertia("Admin/OrderManagements/OrderManage/DeliveredOrders/Index", compact("deliveredOrders"));
    }

    public function show(Request $request, Order $order): Response|ResponseFactory
    {
        $deliveryInformation=DeliveryInformation::where("user_id", $order->user_id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $order->id)->get();

        $queryStringParams=$this->getQueryStringParams($request);

        return inertia("Admin/OrderManagements/OrderManage/DeliveredOrders/Detail", compact("queryStringParams", "order", "deliveryInformation", "orderItems"));
    }
}
