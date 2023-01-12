@extends('layouts.master')
@section('title', 'create Order')
@section('main_content')
    <div class="card" id="vue_app">
        <div class="container-fluid">
            <h6 class="mb-2 p-2">Order</h6>
            <div class="row" style="text-align:right;">
                <div class="col-12">
                    <a href="{{ route('order.create') }}" class="btn btn-sm btn-primary mr-2"><i
                            class="fa-solid fa-plus px-1"></i>Place order</a>
                </div>
            </div>
            <form action="{{ route('order.update_table',$token) }}" method="post" enctype="multipart/form-data" style="text-align:left;">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="table_id" class="form-control-label">Table number (From)<span
                                    class="text-danger font-weight-bold">*</span></label>
                            <select name="table_id" class="form-control" required disabled>
                                    <option value="{{ $table->id }}" selected>{{ $table->name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="table_id_to" class="form-control-label">Table number (To)<span
                                    class="text-danger font-weight-bold">*</span></label>
                            <select name="table_id_to" class="form-control" required>
                                <option value="" selected>{{__('--SELECT--')}}</option>
                                @foreach ($free_tables as $free_table)
                                    <option value="{{ $free_table->id }}">{{ $free_table->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-primary" type="submit"
                            onclick="return confirm('Are you sure you want to Transfer table ?');">Transfer Table</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      
    </script>
@endsection

