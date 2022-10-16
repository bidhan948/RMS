@extends('layouts.master')
@section('title', 'DISCOUNT')
@section('main_content')
@section('is_active_discount', 'active')
<h6 class="mb-2">Edit discount</h6>
<div class="row" style="text-align:right;">
    <div class="col-12">
        <a class="btn btn-sm btn-primary mr-2" href="{{ route('discount.index') }}"><i class="fa-solid fa-backward"></i>
            Back</a>
        <form action="{{ route('discount.update', $discount) }}" method="post" enctype="multipart/form-data"
            style="text-align:left;">
            @csrf
            @method('PUT')
            <div class="col-md-12">
                <div class="form-group">
                    <label for="discount_type" class="form-control-label">Discount Type <span
                            class="text-danger font-weight-bold">*</span></label>
                    <select name="discount_type" id="discount_type" class="form-control"required disabled>
                        <option value="0" {{ $discount->discount_type }}>{{ __('FLAT DISCOUNT') }}</option>
                        <option value="1">{{ __('MENU DISCOUNT') }}</option>
                    </select>
                </div>
            </div>
            <div class="row">
                @if ($discount->is_flat)
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="is_flat" class="form-control-label">Flat Discount (%)<span
                                    class="text-danger font-weight-bold">*</span></label>
                            <input type="text" class="form-control" name="is_flat" value="{{ $discount->discount }}">
                        </div>
                    </div>
                @else
                    <div class="col-md-6+">
                        <div class="form-group">
                            <label for="discount" class="form-control-label">Discount (%)<span
                                    class="text-danger font-weight-bold">*</span></label>
                            <input type="text" class="form-control" name="discount" value="{{ $discount->discount }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="menu_id" class="form-control-label">Menu <span
                                    class="text-danger font-weight-bold">*</span></label>
                            <select name="menu_id" id="menu_id" class="form-control"required disabled>
                                <option value="{{ $discount->menu_id }}">{{ $discount->Menu->name }}</option>
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="from" class="form-control-label">FROM <span
                                class="text-danger font-weight-bold px-1">*</span></label>
                        <input type="date" class="form-control @error('from') is-invalid @enderror" name="from" value="{{ $discount->d_from }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="to" class="form-control-label">TO<span
                                class="text-danger font-weight-bold px-1">*</span></label>
                        <input type="date" class="form-control @error('to') is-invalid @enderror" name="to" value="{{ $discount->d_to }}" required>
                    </div>
                </div>
                <div class="col-6">
                    <button class="btn btn-primary" type="submit"
                        onclick="return confirm('Are you sure you want to submit ?');">Update</button>
                </div>
            </div>
    </div>
</div>
</form>
</div>
@endsection
