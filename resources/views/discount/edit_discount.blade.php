@extends('layouts.master')
@section('title', 'DISCOUNT')
@section('main_content')
@section('is_active_discount', 'active')
<h6 class="mb-2">Edit discount</h6>
<div class="row" style="text-align:right;">
    <div class="col-12">
        <a class="btn btn-sm btn-primary mr-2" href="{{ route('discount.index') }}"><i class="fa-solid fa-backward"></i>
            Back</a>
        <form action="{{ route('discount.store') }}" method="post" enctype="multipart/form-data" style="text-align:left;">
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
                            <input type="text" class="form-control" name="is_flat" value="{{$discount->discount}}">
                        </div>
                    </div>
                @endif
                <div class="col-md-6" v-if="is_flat">
                    <div class="form-group">
                        <label for="from" class="form-control-label">FROM<span
                                class="text-danger font-weight-bold px-1">*</span></label>
                        <input type="date" class="form-control" name="from" value="{{ $discount->from }}">
                    </div>
                </div>
                <div class="col-md-6" v-if="is_flat">
                    <div class="form-group">
                        <label for="to" class="form-control-label">TO<span
                                class="text-danger font-weight-bold px-1">*</span></label>
                        <input type="date" class="form-control" name="to" v-model="form_data.to">
                    </div>
                </div>
            </div>
            <div class="col-md-12 shadow" v-if="is_menu">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                Menu
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Discont (%)
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                FROM
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                TO
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Description
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <select name="menu_id[]" v-model="form_data.menu_id[loop_key]" id="menu_id"
                                    class="form-control form-control-sm">
                                    <option value="">{{ __('--SELECT--') }}</option>
                                    </option>
                                </select>
                            </td>
                            <td class="text-center">
                                <input type="number" step="0.5" class="form-control form-control-sm"
                                    name="discount[]">
                            </td>
                            <td class="text-center">
                                <input type="date" class="form-control form-control-sm" name="from[]">
                            </td>
                            <td class="text-center">
                                <input type="date" class="form-control form-control-sm" name="to[]">
                            </td>
                            <td class="text-center">
                                <textarea name="description[]" class="form-control form-control-sm"></textarea>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-danger mt-2"><i class="fa-solid fa-times px-1"></i> Remove</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
</div>
</form>
</div>
@endsection
