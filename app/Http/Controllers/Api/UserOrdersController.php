<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;

class UserOrdersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $orders = $user
            ->orders()
            ->search($search)
            ->latest()
            ->paginate();

        return new OrderCollection($orders);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Order::class);

        $validated = $request->validate([
            'delivery' => 'required|date',
            'number_of_guest' => 'required|numeric',
            'menu_id' => 'required|exists:menus,id',
        ]);

        $order = $user->orders()->create($validated);

        return new OrderResource($order);
    }
}
