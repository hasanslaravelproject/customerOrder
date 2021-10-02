@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('fixed-foods.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.fixed_foods.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.fixed_foods.inputs.name')</h5>
                    <span>{{ $fixedFood->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fixed_foods.inputs.menu_category_id')</h5>
                    <span
                        >{{ optional($fixedFood->menuCategory)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fixed_foods.inputs.divnumber')</h5>
                    <span>{{ $fixedFood->divnumber ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fixed_foods.inputs.unit_id')</h5>
                    <span>{{ optional($fixedFood->unit)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fixed_foods.inputs.image')</h5>
                    <x-partials.thumbnail
                        src="{{ $fixedFood->image ? \Storage::url($fixedFood->image) : '' }}"
                        size="150"
                    />
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('fixed-foods.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\FixedFood::class)
                <a
                    href="{{ route('fixed-foods.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
