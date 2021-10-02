<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserOrdersDetail extends Component
{
    use AuthorizesRequests;

    public User $user;
    public Order $order;
    public $userMenus = [];
    public $orderDelivery;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Order';

    protected $rules = [
        'orderDelivery' => 'required|date',
        'order.number_of_guest' => 'required|numeric',
        'order.menu_id' => 'required|exists:menus,id',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->userMenus = Menu::pluck('image', 'id');
        $this->resetOrderData();
    }

    public function resetOrderData()
    {
        $this->order = new Order();

        $this->orderDelivery = null;
        $this->order->menu_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newOrder()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.user_orders.new_title');
        $this->resetOrderData();

        $this->showModal();
    }

    public function editOrder(Order $order)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.user_orders.edit_title');
        $this->order = $order;

        $this->orderDelivery = $this->order->delivery->format('Y-m-d');

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->order->user_id) {
            $this->authorize('create', Order::class);

            $this->order->user_id = $this->user->id;
        } else {
            $this->authorize('update', $this->order);
        }

        $this->order->delivery = \Carbon\Carbon::parse($this->orderDelivery);

        $this->order->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Order::class);

        Order::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetOrderData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->user->orders as $order) {
            array_push($this->selected, $order->id);
        }
    }

    public function render()
    {
        return view('livewire.user-orders-detail', [
            'orders' => $this->user->orders()->paginate(20),
        ]);
    }
}
