<?php

namespace App\Http\Livewire;

use App\Models\Unit;
use App\Models\Food;
use Livewire\Component;
use App\Models\MenuCategory;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UnitAllFoodDetail extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public Unit $unit;
    public Food $food;
    public $unitMenuCategories = [];
    public $foodImage;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Food';

    protected $rules = [
        'food.name' => 'required|max:255|string',
        'food.menu_category_id' => 'required|exists:menu_categories,id',
        'food.divnumber' => 'required|numeric',
        'foodImage' => 'nullable|image|max:1024',
    ];

    public function mount(Unit $unit)
    {
        $this->unit = $unit;
        $this->unitMenuCategories = MenuCategory::pluck('name', 'id');
        $this->resetFoodData();
    }

    public function resetFoodData()
    {
        $this->food = new Food();

        $this->foodImage = null;
        $this->food->menu_category_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newFood()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.unit_all_food.new_title');
        $this->resetFoodData();

        $this->showModal();
    }

    public function editFood(Food $food)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.unit_all_food.edit_title');
        $this->food = $food;

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

        if (!$this->food->unit_id) {
            $this->authorize('create', Food::class);

            $this->food->unit_id = $this->unit->id;
        } else {
            $this->authorize('update', $this->food);
        }

        if ($this->foodImage) {
            $this->food->image = $this->foodImage->store('public');
        }

        $this->food->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Food::class);

        collect($this->selected)->each(function (string $id) {
            $food = Food::findOrFail($id);

            if ($food->image) {
                Storage::delete($food->image);
            }

            $food->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetFoodData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->unit->allFood as $food) {
            array_push($this->selected, $food->id);
        }
    }

    public function render()
    {
        return view('livewire.unit-all-food-detail', [
            'allFood' => $this->unit->allFood()->paginate(20),
        ]);
    }
}
