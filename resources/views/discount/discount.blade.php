@extends('layouts.master')
@section('title', 'Discount')
@section('main_content')
@section('is_active_discount', 'active')
<div id="app">
    <h6 class="mb-2">Discount</h6>
    <div class="row" style="text-align:right;">
        <div class="col-12">
            <a class="btn btn-sm btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                    class="fa-solid fa-plus px-1"></i> Add Discount</a>
        </div>
    </div>

    <!--This is Modal for adding item-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="z-index: 1000000;">
        <div class="modal-dialog modal-xl">
            <form action="{{ route('discount.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Discount</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="discount_type" class="form-control-label">Discount Type <span
                                        class="text-danger font-weight-bold">*</span></label>
                                <select name="discount_type" id="discount_type" class="form-control"
                                    v-model="form_data.discount_type" v-on:change="discountType()" required>
                                    <option value="">{{ __('--SELECT--') }}</option>
                                    <option value="0">{{ __('FLAT DISCOUNT') }}</option>
                                    <option value="1">{{ __('MENU DISCOUNT') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" v-if="is_flat">
                            <div class="form-group">
                                <label for="is_flat" class="form-control-label">Flat Discount (%)<span
                                        class="text-danger font-weight-bold">*</span></label>
                                <input type="text" class="form-control" name="is_flat" v-model="form_data.is_flat">
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
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Discont (%)
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Description
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <a class="btn btn-sm btn-primary mt-2" v-on:click="addBlock()"><i
                                                    class="fa-solid fa-plus px-1"></i> Add more</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(loop,loop_key) in form_data.menu_id" :unique-key="true" :key="loop_key" :id="`avion-${loop_key}`">
                                        <td class="text-center">
                                            <select name="menu_id[]" v-model="form_data.menu_id[loop_key]" id="menu_id" class="form-control form-control-sm">
                                                <option value="">{{ __('--SELECT--') }}</option>
                                                <option :value="menu.id" v-for="(menu,menu_key) in menus"
                                                    v-text="menu.name"></option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <input type="number" step="0.5" class="form-control form-control-sm"
                                                name="discount[]" v-model="form_data.discount[loop_key]">
                                        </td>
                                        <td class="text-center">
                                            <textarea name="description[]" class="form-control form-control-sm" v-model="form_data.description[loop_key]"></textarea>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-danger mt-2" v-on:click="remove(loop_key)"><i
                                                    class="fa-solid fa-times px-1"></i> Remove</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to Submit ?');">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--end of Modal for adding item-->

    <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">S.No
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                        Name
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Discount
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action
                    </th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script>
    new Vue({
        el: "#app",
        data: {
            menus: @json($menus),
            is_menu: false,
            is_flat: false,
            form_data: {
                discount_type: '',
                is_flat: '',
                menu_id:[''],
                discount : [],
                description : [],
            }
        },
        methods: {
            discountType: function() {
                let vm = this;
                if (vm.form_data.discount_type == 1) {
                    vm.is_menu = true;
                    vm.is_flat = false;
                } else if (vm.form_data.discount_type == 0) {
                    vm.is_menu = false;
                    vm.is_flat = true;
                }
            },
            addBlock: function() {
                this.form_data.menu_id.push('');
                this.form_data.discount.push('');
                this.form_data.description.push('');
            },
            remove : function(index){
                this.form_data.menu_id.splice(index, 1);
                this.form_data.discount.splice(index, 1);
                this.form_data.description.splice(index, 1);
            }
        },
        mounted() {
            let vm = this;
        }
    });
</script>
<script>
    $(function() {
        if ({{ $errors->any() }}) {
            $("#exampleModal").show();
        }
    });
</script>
@endsection
