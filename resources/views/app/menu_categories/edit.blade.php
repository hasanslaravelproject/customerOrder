@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('menu-categories.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.menu_categories.edit_title')
            </h4>

            <x-form
                method="PUT"
                action="{{ route('menu-categories.update', $menuCategory) }}"
                class="mt-4"
            >
                @include('app.menu_categories.form-inputs')

                <div class="mt-4">
                    <a
                        href="{{ route('menu-categories.index') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <a
                        href="{{ route('menu-categories.create') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-add text-primary"></i>
                        @lang('crud.common.create')
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.update')
                    </button>
                </div>
            </x-form>
        </div>
    </div>

    @can('view-any', App\Models\Menu::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title">Menus</h4>

            <livewire:menu-category-menus-detail
                :menuCategory="$menuCategory"
            />
        </div>
    </div>
    @endcan @can('view-any', App\Models\FixedFood::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title">Fixed Foods</h4>

            <livewire:menu-category-fixed-foods-detail
                :menuCategory="$menuCategory"
            />
        </div>
    </div>
    @endcan @can('view-any', App\Models\Food::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title">All Food</h4>

            <livewire:menu-category-all-food-detail
                :menuCategory="$menuCategory"
            />
        </div>
    </div>
    @endcan
</div>
@endsection
