@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('all-food.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.all_food.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.all_food.inputs.name')</h5>
                    <span>{{ $food->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_food.inputs.menu_category_id')</h5>
                    <span
                        >{{ optional($food->menuCategory)->name ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_food.inputs.divnumber')</h5>
                    <span>{{ $food->divnumber ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_food.inputs.unit_id')</h5>
                    <span>{{ optional($food->unit)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_food.inputs.image')</h5>
                    <x-partials.thumbnail
                        src="{{ $food->image ? \Storage::url($food->image) : '' }}"
                        size="150"
                    />
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('all-food.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Food::class)
                <a href="{{ route('all-food.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
