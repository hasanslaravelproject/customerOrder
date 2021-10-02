<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;

class MenuOrdersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Menu $menu)
    {
        $this->authorize('view', $menu);

        $search = $request->get('search', '');

        $orders = $menu
            ->orders()
            ->search($search)
            ->latest()
            ->paginate();

        return new OrderCollection($orders);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Menu $menu)
    {
        $this->authorize('create', Order::class);

        $validated = $request->validate([
            'delivery' => 'required|date',
            'number_of_guest' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        $order = $menu->orders()->create($validated);

        return new OrderResource($order);
    }
}
