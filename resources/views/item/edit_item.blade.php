@extends('layouts.master')
@section('title', 'ITEM')
@section('main_content')
@section('is_active_item', 'active')
<h6 class="mb-2">items list</h6>
<div class="row" style="text-align:right;">
    <div class="col-12">
        <a class="btn btn-sm btn-primary mr-2" href="{{ route('item.index') }}"><i class="fa-solid fa-backward"></i>
            Back</a>
        <form action="{{ route('item.update', $item) }}" method="post" enctype="multipart/form-data"
            style="text-align:left;">
            @method('PUT')
            @csrf
            <h5 class="mb-2">Edit item</h5>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="form-control-label">Name <span
                            class="text-danger font-weight-bold">*</span></label>
                    <input name="name" class="form-control @error('name') is-invalid @enderror" type="text"
                        required value="{{ $item->name }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="menu_id" class="form-control-label">Menu <span
                            class="text-danger font-weight-bold">*</span></label>
                    <select name="menu_id" id="menu_id" class="form-control" required>
                        <option value="">{{ __('--SELECT--') }}</option>
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->id }}" {{ $item->menu_id == $menu->id ? 'selected' : '' }}>
                                {{ $menu->name }}</option>
                        @endforeach
                    </select>
                    @error('menu_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="menu_id" class="form-control-label">Price <span
                            class="text-danger font-weight-bold">*</span></label>
                    <input type="number" name="price" class="form-control" value="{{ $item->price }}" required>
                    @error('menu_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="menu_id" class="form-control-label">Discount (%) <span
                            class="text-danger font-weight-bold">*</span></label>
                    <input type="number" name="discount" class="form-control" value="{{ $item->discount }}"
                        step="0.5" required>
                    @error('discount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-md-12 mt-1">
                <div class="form-group">
                    <label for="name" class="form-control-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" required>{{ $item->description }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-2 my-2">
                <button type="submit" class="btn btn-sm btn-primary"
                    onclick="return confirm('Are you sure you want to confirm ?')">Submit</button>
            </div>
    </div>
    </form>
</div>
</div>
@endsection
