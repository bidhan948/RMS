@extends('layouts.master')
@section('title', 'ITEM')
@section('main_content')
@section('is_active_item', 'active')
<div id="app">
    <div class="card shadow-lg p-3 mb-2">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name" class="form-control-label">Menu </label>
                    <select id="menu_id" v-model="data.menu_id" class="form-control form-control-sm">
                        <option value="">--SELECT--</option>
                        <option :value="menu.id" v-for="(menu,menu_key) in setting_menus" v-text="menu.name"></option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name" class="form-control-label">Price range FROM </label>
                    <input type="text" class="form-control form-control-sm" v-model="data.from">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name" class="form-control-label">Price range TO </label>
                    <input type="text" class="form-control form-control-sm" v-model="data.to">
                </div>
            </div>
            <div class="col-md-3" style="margin-top:30px;">
                <button class="btn btn-sm btn-danger" id="search" v-on:click="loadData()"
                    :disabled="is_loading">Search</button>
            </div>
        </div>
    </div>
    <h6 class="mb-2">items list</h6>
    <div class="row" style="text-align:right;">
        <div class="col-12">
            <a class="btn btn-sm btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                    class="fa-solid fa-plus px-1"></i> Add Item</a>
        </div>
    </div>

    <!--This is Modal for adding item-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="z-index: 1000000;">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="form-control-label">Name <span
                                        class="text-danger font-weight-bold">*</span></label>
                                <input name="name" class="form-control @error('name') is-invalid @enderror"
                                    type="text" required>
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
                                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
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
                                <input type="number" name="price" class="form-control" value="{{ old('price') }}"
                                    required>
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
                                <input type="number" name="discount" class="form-control" value="0"
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
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" required></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
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
                <template v-for="(menu,key) in menus">
                    <tr>
                        <td class="text-center"colspan="5"><strong><span v-text="menu.name"></span></strong></td>
                    </tr>
                    <tr v-for="(item,item_key) in menu.items">
                        <td class="text-center" v-text="item_key+1"></td>
                        <td class="text-center" v-text="item.name"></td>
                        <td class="text-center"> <span class="px-1">RS.</span> <s
                                v-text="item.discount ? item.price : ''"></s> <span class="px-1"
                                v-text="item.discount ? ((100-item.discount)/100)*item.price : item.price"></span>
                        </td>
                        <td class="text-center" v-text="item.discount + '%'"></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" v-on:click="redirectEdit(item.id)">Edit</a>
                        </td>
                    </tr>
                </template>
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
            is_loading: false,
            menus: [],
            setting_menus : @json($menus),
            data: {
                menu_id: '',
                from: '',
                to: ''
            }
        },
        methods: {
            redirectEdit: function(item_id) {
                let vm = this;
                window.location.href = "{{ url('/') }}/" + 'item/' + item_id + '/edit';
            },
            loadData: function() {
                let vm = this;
                button = document.getElementById("search");
                vm.is_loading = true;
                button.innerHTML = "<span>Loading....</span>";
                axios.post("{{ route('item.report') }}",
                    vm.data
                ).then(function(response) {
                    vm.menus = response.data;
                    vm.is_loading = false;
                    button.innerHTML = "<span>Search</span>";
                }).catch(function(error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            let vm = this;
            vm.loadData();
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
