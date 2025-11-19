@extends('admin/admin_layout/nav')

@section('title', 'Menu Items')

@section('content')
@if(session('success'))
    <div id="success-message" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h3>{{ __('Menu Items') }}</h3>
                        </div>
                        <div class="col-2 text-right">
                            <a href="{{ route('menu_items.create') }}" class="btn btn-success">{{ __('Create New Product') }}</a>
                        </div>
                    </div>
                </div>
                @if($menuItems->count() > 0)
                <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="navbar-brand nav-link {{ !request('category') ? 'active' : '' }}" href="{{ route('menu_items.menuItemCRUD') }}">{{ __('All') }}</a>
                                </li>
                                @foreach($categories as $category)
                                    @php
                                        $menu_items = $category->menuItems()->get();
                                    @endphp
                                    @if(count($menu_items) > 0)
                                        <li class="nav-item">
                                            <a class="nav-link {{ request('category') == $category->category_id ? 'active fw-bold' : '' }}" href="{{ route('menu_items.menuItemCRUD', ['category' => $category->category_id]) }}">{{ $category->category_name }}</a>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <span class="nav-link disabled">{{ $category->category_name }}</span></span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </nav>         
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 20%">{{ __('Name') }}</th>
                                    <th style="width: 25%">{{ __('Description') }}</th>
                                    <th style="width: 15%">{{ __('Price') }}</th>
                                    <th style="width: 15%">{{ __('Item Cost') }}</th>
                                    <th style="width: 15%">{{ __('Stock') }}</th>
                                    <th style="width: 10%">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($menuItems as $menuItem)
                                    <tr>
                                        <td>{{ $menuItem->item_name }}</td>
                                        <td>{{ $menuItem->description }}</td>
                                        <td>RM{{ $menuItem->price }}</td>
                                        <td>RM{{ $menuItem->item_cost }}</td>
                                        <td class="{{ $menuItem->isAvailable() ? 'text-success' : 'text-danger' }}">
                                            {{ $menuItem->isAvailable() ? __('In Stock') : __('Out of Stock') }}
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="{{ __('Actions') }}">
                                                <div class="button" role="group">
                                                    <a href="{{ route('menu_items.show', $menuItem) }}" class="btn btn-sm btn-primary">{{ __('View') }}</a>
                                                </div>
                                                <div class="button" role="group" style="margin-left: 10px; margin-right: 10px;">
                                                    <a href="{{ route('menu_items.edit', $menuItem) }}" class="btn btn-sm btn-warning">{{ __('Edit') }}</a>
                                                </div>
                                                <div class="button" role="group">
                                                    <form action="{{ route('menu_items.destroy', $menuItem) }}" method="POST" onsubmit="return confirm(`{{ __('Are you sure you want to delete this item?') }}`)">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No menu items found.</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    // Auto-hide the success message after 5 seconds
    setTimeout(function() {
        $('#success-message').fadeOut('slow');
    }, 5000);
</script>
@endsection
@section('styles')
<style>
    .table td {
        vertical-align: middle;
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
@endsection