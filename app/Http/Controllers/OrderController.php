<?php

namespace App\Http\Controllers;

use App\Helper\RMShelper;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\menu;
use App\Models\order;
use App\Models\table;
use App\Repo\OrderRepo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    protected $orderRepo;

    public function __construct(orderRepo $obj)
    {
        $this->orderRepo = $obj;
    }
    public function index(): View
    {
        return view('order.order');
    }

    public function orderReport(Request $request)
    {
        return $this->orderRepo->orderIndex($request->all());
    }

    public function create(): View
    {
        return view('order.create_order', [
            'menus' => menu::query()->get(),
            'tables' => table::query()->get()
        ]);
    }

    public function store(OrderRequest $request, RMShelper $helper)
    {
        DB::beginTransaction();
        try {

            order::query()
                ->where('table_id', $request->table_id)
                ->where('status', false)
                ->delete();
            $token = $helper->generateRandomToken();

            foreach ($request->menu_id as $key => $menu_id) {
                order::create([
                    'menu_id' => $menu_id,
                    'item_id' => $request->item_id[$key],
                    'table_id' => $request->table_id,
                    'quantity' => $request->quantity[$key],
                    'price' => $request->price[$key],
                    'total' => $request->quantity[$key] * $request->price[$key],
                    'token' => $token
                ]);
            }
            toast('Successfully added to cart', "success");
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Something wenty wrong...');
            return redirect()->back();
        }

        return redirect()->route('order.index');
    }

    public function proceedToPayment($token): View
    {
        $orders = order::query()->where('token', $token)->get();

        abort_if(!$orders->count(), 404);
        abort_if($orders[0]->status, 404);

        return view('order.proceed_payment', [
            'orders' => $orders,
            'menus' => menu::query()->get(),
            'tables' => table::query()->get()
        ]);
    }

    public function proceedPaymentSubmit(OrderUpdateRequest $request, $token)
    {
        DB::beginTransaction();
        try {
            $orders = order::query()->where('token', $token)->forceDelete();
            foreach ($request->menu_id as $key => $menu_id) {
                order::create([
                    'menu_id' => $menu_id,
                    'item_id' => $request->item_id[$key],
                    'table_id' => $request->table_id,
                    'quantity' => $request->quantity[$key],
                    'price' => $request->price[$key],
                    'total' => $request->quantity[$key] * $request->price[$key],
                    'discount' => $request->discount,
                    'paid_amount' => $request->grand_total,
                    'rcv_amount' => $request->rcv_amount,
                    'refund' => $request->refund,
                    'token' => $token,
                    'status' => true,
                    'description' => $request->description
                ]);
            }
            toast('Payment done successfully', "success");
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Something wenty wrong...');
            return redirect()->back();
        }

        return redirect()->route('order.index');
    }

    public function orderHistory(): View
    {
        return view('order.history');
    }

    public function historyReport(Request $request)
    {
        return $this->orderRepo->orderHistoryIndex($request->all());
    }

    public function printBill($token)
    {
        $orders = order::query()
            ->where('token', $token)
            ->where('status', true)
            ->with('Table', 'Item', 'menu')
            ->get();

        abort_if(!$orders->count(), 404);

        return view('order.print_bill', [
            'orders' => $orders,
        ]);
    }

    public function editTable($token)
    {
        $orders = order::query()->where('token', $token)->get();

        abort_if(!$orders->count(), 404);
        abort_if($orders[0]->status, 404);

        $table = table::query()->where('id', $orders[0]->table_id)->first();

        if ($table == null) {
            Alert::error("Table Not assigned");
            return redirect()->back();
        }

        return view(
            'order.edit-table',
            [
                'orders' => $orders,
                'tables' => table::query()->get(),
                'menus' => menu::query()->get(),
                'table' => $table
            ]
        );
    }
}
