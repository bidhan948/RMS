@extends('layouts.master')
@section('title', 'Order History')
@section('main_content')
    <div class="card">
        <div class="container-fluid">
            <h6 class="mb-2 p-2">
                <a href="{{route('order.index')}}" class="btn btn-sm btn-primary"><i class="fa-solid fa-cart-shopping px-1"></i>Current Order</a>
                <a href="{{route('order.history')}}" class="btn btn-sm btn-success"><i class="fa-solid fa-clock-rotate-left px-1"></i> View Order history</a>
            </h6>
            {{-- <div class="row" style="text-align:right;">
                <div class="col-12">
                    <a href="{{ route('order.create') }}" class="btn btn-sm btn-primary mr-2"><i
                            class="fa-solid fa-plus px-1"></i>Place order</a>
                </div>
            </div> --}}
            <div class="table-responsive p-0" id="vue_app">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">S.No
                            </th>
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                Table
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(order,key) in orders">
                            <tr>
                                <td class="text-center" v-text="key+1"></td>
                                <td class="text-center" v-text="order[0].table.name"></td>
                                <td class="text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#orderDetail" v-on:click="openModal(key)">
                                        View Order detail <i class="fa-solid fa-circle-info px-1"></i>
                                    </button>
                                    <a type="button" class="btn btn-danger" v-on:click="redirectPrintBill(order[0].token)">
                                        Print Bill  <i class="fa-sharp fa-solid fa-money-bill px-1"></i>
                                    </a>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                {{-- modal --}}
                <!-- Modal -->
                <div class="modal modal-lg fade" id="orderDetail" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" v-if="modal_order.length">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"
                                    v-text="modal_order[0].table.name + ' Detail'"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                S.No
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                Item
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Quantity
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Price
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(m_order,modal_order_key) in modal_order">
                                            <tr>
                                                <td class="text-center" v-text="modal_order_key+1"></td>
                                                <td class="text-center" v-text="m_order.item.name"></td>
                                                <td class="text-center" v-text="m_order.quantity"></td>
                                                <td class="text-center" v-text="m_order.price"></td>
                                                <td class="text-center" v-text="m_order.total"></td>
                                            </tr>
                                        </template>
                                        <tr>
                                            <td class="text-center" colspan="4">Total :</td>
                                            <td class="text-center" v-text="returnTotal(modal_order_key)"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="4">Discount :</td>
                                            <td class="text-center" v-text="returnDiscount(modal_order_key)"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="4">Total :</td>
                                            <td class="text-center" v-text="returnGrandTotal(modal_order_key)"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {{-- <script src="{{ asset('vue/bundle.js') }}"></script> --}}
    <script defer>
        new Vue({
            el: "#vue_app",
            data: {
                is_loading: false,
                orders: [],
                modal_order: [],
                data: {
                    // menu_id: '',
                    // from: '',
                    // to: ''
                }
            },
            methods: {
                loadData: function() {
                    let vm = this;
                    // button = document.getElementById("search");
                    // vm.is_loading = true;
                    // button.innerHTML = "<span>Loading....</span>";
                    axios.post("{{ route('order.historyReport') }}").then(function(response) {
                        vm.orders = response.data;
                        console.log(vm.orders);
                        // vm.is_loading = false;
                        // button.innerHTML = "<span>Search</span>";
                    }).catch(function(error) {
                        console.log(error);
                    });
                },
                openModal: function(param) {
                    let vm = this;
                    vm.modal_order = vm.orders[param];
                    console.log(vm.modal_order);
                },
                returnGrandTotal: function(params) {
                    let vm = this;
                    grand_total = 0;
                    vm.modal_order.forEach((val, index) => {
                        grand_total += (100 - val.discount) / 100 * val.price * val.quantity;
                    });

                    return grand_total;
                },
                returnTotal: function(params) {
                    let vm = this;
                    grand_total = 0;
                    vm.modal_order.forEach((val, index) => {
                        grand_total += val.price * val.quantity;
                    });

                    return grand_total;
                },
                returnDiscount: function(params) {
                    let vm = this;
                    grand_total = 0;
                    vm.modal_order.forEach((val, index) => {
                        grand_total += (val.discount) / 100 * val.price * val.quantity;
                    });

                    return grand_total;
                },
                redirectPayment: function(params) {
                    let vm = this;
                    window.location.href = "{{ url('/') }}/" + 'order/proceed-to-payment/' + params;
                },
                redirectPrintBill : function (params) {
                    let vm = this;
                    window.location.href = "{{ url('/') }}/" + 'order/print-bill/' + params;
                }
            },
            mounted() {
                let vm = this;
                vm.loadData();
            }
        });
    </script>
@endsection
