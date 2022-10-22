@extends('layouts.master')
@section('title', 'Order')
@section('main_content')
    <div class="card">
        <div class="container-fluid">
            <h6 class="mb-2 p-2">Order</h6>
            <div class="row" style="text-align:right;">
                <div class="col-12">
                    <a href="{{ route('order.create') }}" class="btn btn-sm btn-primary mr-2"><i
                            class="fa-solid fa-plus px-1"></i>Place order</a>
                </div>
            </div>
        </div>
    </div>
@endsection
