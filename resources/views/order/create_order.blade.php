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
            <form action="{{ route('order.store') }}" method="post" enctype="multipart/form-data" style="text-align:left;">
                @csrf
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="table_id" class="form-control-label">Table number<span
                                class="text-danger font-weight-bold">*</span></label>
                        <select name="table_id" id="table_id" class="form-control"required>
                            <option value="">{{ __('--SELECT--') }}</option>
                            @foreach ($tables as $key => $table)
                                <option value="{{ $table->id }}">{{ $table->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <table class="table align-items-center mb-0" id="table">
                    <thead>
                        <tr>
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                Menu
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Item
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Quantity
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Price
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Total
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <a class="btn btn-sm btn-primary mt-2" id="addMore"><i class="fa-solid fa-plus px-1"></i>
                                    Add more</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        <tr id="row_0">
                            <td class="text-center">
                                <select name="menu_id[]" id="menu_id_0" class="form-control form-control-sm"
                                    onchange="returnItem(0)">
                                    <option value="">{{ __('--SELECT--') }}</option>
                                    @foreach ($menus as $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                    </option>
                                </select>
                            </td>
                            <td class="text-center" id="td_item_0">
                                <select name="item_id[]" id="item_id_0" class="form-control form-control-sm"
                                    onchange="returnPrice(0)">
                                    <option value="">{{ __('--SELECT--') }}</option>
                                    </option>
                                </select>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm" name="quantity[]" id="quantity_0"
                                    value="0" oninput="calculateRowTotal(0)">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm" name="price[]" id="price_0"
                                    readonly>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm" name="total[]" id="total_0"
                                    readonly>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-danger mt-2"><i class="fa-solid fa-times px-1"></i> Remove</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-6">
                    <button class="btn btn-primary" type="submit"
                        onclick="return confirm('Are you sure you want to submit ?');">Add to cart</button>
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
        let i = 1;
        $(function() {
            $("#table").css("display", "none");

            $("#table_id").on("change", function() {
                table_id = $("#table_id").val();
                if (table_id == "") {
                    alert("Please select tgable no.");
                    $("#table").css("display", "none");
                } else {
                    $("#table").css("display", "");
                }
            });

            $("#addMore").on("click", function() {
                html = '<tr id="row_'+i+'">'
                            +'<td class="text-center">'
                                +'<select name="menu_id[]" id="menu_id_'+i+'" class="form-control form-control-sm"'
                                    +'onchange="returnItem('+i+')">'
                                    +'<option value="">{{ __("--SELECT--") }}</option>'
                                    +'@foreach ($menus as $menu)'
                                        +'<option value="{{ $menu->id }}">{{ $menu->name }}</option>'
                                    +'@endforeach'
                                    +'</option>'
                                +'</select>'
                            +'</td>'
                            +'<td class="text-center" id="td_item_'+i+'">'
                                +'<select name="item_id[]" id="item_id_'+i+'" class="form-control form-control-sm"'
                                    +'onchange="returnPrice('+i+')">'
                                    +'<option value="">{{ __("--SELECT--") }}</option>'
                                    +'</option>'
                                +'</select>'
                            +'</td>'
                            +'<td class="text-center">'
                                +'<input type="number" class="form-control form-control-sm" name="quantity[]" id="quantity_'+i+'"'
                                    +'value="0" oninput="calculateRowTotal('+i+')">'
                            +'</td>'
                            +'<td class="text-center">'
                                +'<input type="number" class="form-control form-control-sm" name="price[]" id="price_'+i+'"readonly>'
                            +'</td>'
                            +'<td class="text-center">'
                                +'<input type="number" class="form-control form-control-sm" name="total[]" id="total_'+i+'" readonly></td>'
                            +'<td class="text-center">'
                                +'<a class="btn btn-sm btn-danger mt-2"><i class="fa-solid fa-times px-1"></i> Remove</a></td></tr>';
                
                $("#table_body").append(html);
                i++;
            });
        });

        function returnItem(params) {
            menu_id = $("#menu_id_" + params).val();
            axios.get("{{ route('api.getItemByMenu') }}", {
                params: {
                    menu_id: menu_id,
                    index: params
                }
            }).then(function(response) {
                $("#td_item_" + params).html(response.data.html);
            }).catch(function(error) {
                alert("Something went wrong...");
            });
        }

        function returnPrice(params) {
            item_id = $("#item_id_" + params).val();
            if (item_id == '') {
                alert("Please select item");
                $("#quantity_" + params).val(0);
                $("#price_" + params).val(0);
                $("#total_" + params).val(0);
            } else {
                axios.get("{{ route('api.getItemPrice') }}", {
                    params: {
                        item_id: item_id
                    }
                }).then(function(response) {
                    $("#price_" + params).val(response.data.price);
                    calculateRowTotal(params);
                }).catch(function(error) {
                    alert("Something went wrong...");
                });
            }
        }

        function calculateRowTotal(params) {
            quantity = +$("#quantity_" + params).val() || 0;
            price = +$("#price_" + params).val() || 0;
            $("#total_" + params).val(quantity * price);
        }
    </script>
@endsection

