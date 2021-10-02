<?php

namespace App\Http\Livewire;

use App\Models\Unit;
use Livewire\Component;
use App\Models\FixedFood;
use App\Models\MenuCategory;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MenuCategoryFixedFoodsDetail extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public MenuCategory $menuCategory;
    public FixedFood $fixedFood;
    public $menuCategoryUnits = [];
    public $fixedFoodImage;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New FixedFood';

    protected $rules = [
        'fixedFood.name' => 'required|max:255|string',
        'fixedFood.divnumber' => 'required|numeric',
        'fixedFood.unit_id' => 'required|exists:units,id',
        'fixedFoodImage' => 'nullable|image|max:1024',
    ];

    public function mount(MenuCategory $menuCategory)
    {
        $this->menuCategory = $menuCategory;
        $this->menuCategoryUnits = Unit::pluck('name', 'id');
        $this->resetFixedFoodData();
    }

    public function resetFixedFoodData()
    {
        $this->fixedFood = new FixedFood();

        $this->fixedFoodImage = null;
        $this->fixedFood->unit_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newFixedFood()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.menu_category_fixed_foods.new_title');
        $this->resetFixedFoodData();

        $this->showModal();
    }

    public function editFixedFood(FixedFood $fixedFood)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.menu_category_fixed_foods.edit_title');
        $this->fixedFood = $fixedFood;

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

        if (!$this->fixedFood->menu_category_id) {
            $this->authorize('create', FixedFood::class);

            $this->fixedFood->menu_category_id = $this->menuCategory->id;
        } else {
            $this->authorize('update', $this->fixedFood);
        }

        if ($this->fixedFoodImage) {
            $this->fixedFood->image = $this->fixedFoodImage->store('public');
        }

        $this->fixedFood->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', FixedFood::class);

        collect($this->selected)->each(function (string $id) {
            $fixedFood = FixedFood::findOrFail($id);

            if ($fixedFood->image) {
                Storage::delete($fixedFood->image);
            }

            $fixedFood->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetFixedFoodData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->menuCategory->fixedFoods as $fixedFood) {
            array_push($this->selected, $fixedFood->id);
        }
    }

    public function render()
    {
        return view('livewire.menu-category-fixed-foods-detail', [
            'fixedFoods' => $this->menuCategory->fixedFoods()->paginate(20),
        ]);
    }
}
