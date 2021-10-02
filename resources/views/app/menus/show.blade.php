@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('menus.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.menus.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.menus.inputs.company_id')</h5>
                    <span>{{ optional($menu->company)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.menus.inputs.menu_category_id')</h5>
                    <span
                        >{{ optional($menu->menuCategory)->name ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.menus.inputs.image')</h5>
                    <x-partials.thumbnail
                        src="{{ $menu->image ? \Storage::url($menu->image) : '' }}"
                        size="150"
                    />
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('menus.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Menu::class)
                <a href="{{ route('menus.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
