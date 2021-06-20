<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderTransactions;
use Illuminate\Support\Facades\DB;
use App\TransactionId\Transaction;
use App\Models\SalesCart;
use Carbon\Carbon;
use PDF;
use App\Models\SalesReturn;
use App\Models\SalesReturnProductDetails;
use App\Models\SubAccounts;
use App\Common\AccountType;
use App\Models\SalesAccountsSetup;
use Illuminate\Support\Facades\Mail;
use App\Common\SaleCloseStatus;
use App\Common\TransactionType;
use App\Models\TransactionDetails;
use App\Models\ItemsCart;
use App\Models\RestSale;
use App\Models\RestSaleItem;
use App\Models\DineInTable;
use App\Models\DineInTableItems;
use App\Models\TakeAwaySale;
use App\Models\TakeAwayItems;
use App\Models\DeliverySale;
use App\Models\DeliverySaleItems;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;
use App\Models\Items;
use App\Models\KitchenOrder;
use App\Models\KitchenOrderItems;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use RealRashid\SweetAlert\Facades\Alert;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function viewMenu()
    {
        $products = Product::get();
        $orders = Order::get();
        //last order details
        $lastId = OrderDetails::max('order_id');
        $orderReceipt = OrderDetails::leftjoin('products', 'products.transaction_id', 'order_details.product_id')
            ->leftjoin('orders', 'orders.id', 'order_details.order_id')
            ->where('order_details.order_id', $lastId)->get();
        $name = Auth::user()->user_name;
        return view('sales.index', ['name' => $name, 'products' => $products, 'orders' => $orders, 'order_receipt' => $orderReceipt]);
    }

    public function storeSales(Request $request)
    {
        try {
            DB::beginTransaction();
            //customer details
            $orders = new Order();
            $orders->transaction_id = Transaction::setTransactionId();
            $orders->name = $request->customer_name;
            $orders->phone = $request->customer_phone;
            $orders->barcode = mt_rand(1000000, 9999999);
            $orders->save();

            //Order details

            for ($product_id = 0; $product_id < count($request->product_id); $product_id++) {
                $order_details = new OrderDetails();
                $order_details->transaction_id = Transaction::setTransactionId();
                $order_details->order_id = $orders->id;
                $order_details->product_id = $request->product_id[$product_id];
                $order_details->unitprice = $request->price[$product_id];
                $order_details->quantity = $request->quantity[$product_id];
                $order_details->discount = $request->discount[$product_id];
                $order_details->amount = $request->total_amount[$product_id];
                $order_details->save();
            }

            $orderTransactions = new OrderTransactions();
            $orderTransactions->transaction_id = Transaction::setTransactionId();
            $orderTransactions->order_id = $orders->id;
            $orderTransactions->user_id = Auth::user()->user_id;
            $orderTransactions->balance = $request->balance;
            $orderTransactions->paid_amount = $request->paid_amount;
            $orderTransactions->payment_method = $request->payment_method;
            $orderTransactions->save();

            //last order history
            $name = Auth::user()->user_name;
            $products = Product::all();
            $order_details = OrderDetails::where('order_id', $orders->id)->get();
            $orderdBy = Order::where('id', $orders->id)->get();

            $clearCart = SalesCart::query()->truncate();

            DB::commit();

            return view('sales.index', ['name' => $name, 'products' => $products, 'order_details' => $order_details, 'customer_orders' => $orderdBy]);
        } catch (\Exception $e) {
            return back()->with("Product orders Fails to inserted! check your inputs!");
        }
    }

    public function viewReciept()
    {
        return view('sales.receipt');
    }

    public function salesReport(Request $request)
    {
        if ($request->type == 'daily') {
            $dailyReport = Order::leftjoin('order_details', 'order_details.order_id', 'orders.id')
                ->whereDay('orders.created_at', now()->day)
                ->select(
                    DB::raw('DATE_FORMAT(orders.created_at, "%H:%i:%s") as time'),
                    'orders.name as customerName',
                    DB::raw('DATE_FORMAT(orders.created_at, "%d-%m-%Y") as date'),
                    'orders.name',
                    'order_details.amount'
                )
                ->get();

            $today = Carbon::now()->format('d-F-Y');

            $totalSale = $dailyReport->sum('amount');

            $pdf = PDF::loadView('sales.report', ['today' => $today, 'total' => $totalSale, 'report' => $dailyReport, 'type' => $request->type]);

            //  download PDF file with download method
            return $pdf->download('DailyReport.pdf');
        } elseif ($request->type == 'weekly') {
            $weeklyReport = Order::leftjoin('order_details', 'order_details.order_id', 'orders.id')
                ->whereBetween('orders.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->select(
                    DB::raw('DATE_FORMAT(orders.created_at, "%H:%i:%s") as time'),
                    'orders.name as customerName',
                    DB::raw('DATE_FORMAT(orders.created_at, "%d-%m-%Y") as date'),
                    'orders.name',
                    'order_details.amount'
                )
                ->get();

            $today = Carbon::now()->format('d-F-Y');

            $totalSale = $weeklyReport->sum('amount');

            $pdf = PDF::loadView('sales.report', ['today' => $today, 'total' => $totalSale, 'report' => $weeklyReport, 'type' => $request->type]);

            //  download PDF file with download method
            return $pdf->download('WeeklyReport.pdf');
        } elseif ($request->type == 'monthly') {
            $monthlyReport = Order::leftjoin('order_details', 'order_details.order_id', 'orders.id')
                ->whereMonth('orders.created_at', Carbon::now()->month)
                ->select(
                    DB::raw('DATE_FORMAT(orders.created_at, "%H:%i:%s") as time'),
                    'orders.name as customerName',
                    DB::raw('DATE_FORMAT(orders.created_at, "%d-%m-%Y") as date'),
                    'orders.name',
                    'order_details.amount'
                )
                ->get();

            $totalSale = $monthlyReport->sum('amount');

            $today = Carbon::now()->format('d-F-Y');

            $pdf = PDF::loadView('sales.report', ['today' => $today, 'total' => $totalSale, 'report' => $monthlyReport, 'type' => $request->type]);

            //  download PDF file with download method
            return $pdf->download('MonthlyReport.pdf');
        } else {

            $fromDate = date('Y-m-d', strtotime($request->fromDate)) . ' 00:00:00';
            $toDate = date('Y-m-d', strtotime($request->toDate)) . ' 23:59:59';

            $report = Order::leftjoin('order_details', 'order_details.order_id', 'orders.id')
                ->whereBetween('orders.created_at', [$fromDate, $toDate])
                ->select(
                    DB::raw('DATE_FORMAT(orders.created_at, "%H:%i:%s") as time'),
                    'orders.name as customerName',
                    DB::raw('DATE_FORMAT(orders.created_at, "%d-%m-%Y") as date'),
                    'orders.name',
                    'order_details.amount'
                )
                ->get();

            $totalSale = $report->sum('amount');

            $today = Carbon::now()->format('d-F-Y');

            $pdf = PDF::loadView('sales.report', ['today' => $today, 'total' => $totalSale, 'report' => $report, 'type' => 'Sales']);

            //  download PDF file with download method
            return $pdf->download('SalesReport.pdf');
        }
    }

    public function salesReturn()
    {
        $name = Auth::user()->user_name;
        return view('sales.salesReturn', ['name' => $name]);
    }

    public function storeSalesReturn(Request $request)
    {
        try {
            DB::beginTransaction();

            $salesReturn = new SalesReturn();
            $salesReturn->transaction_id = Transaction::setTransactionId();
            $salesReturn->bill_no = $request->bill_no;
            $salesReturn->customer_name = $request->customer_name;
            $salesReturn->customer_phone = $request->customer_phone;
            $salesReturn->paid_amount = $request->paid_amount;
            $salesReturn->return_amount = $request->return_amount;
            $salesReturn->save();

            for ($product_id = 0; $product_id < count($request->product_id); $product_id++) {
                $returnDetails = new SalesReturnProductDetails();
                $returnDetails->transaction_id = Transaction::setTransactionId();
                $returnDetails->order_id = $request->bill_no;
                $returnDetails->sales_return_id = $salesReturn->transaction_id;
                $returnDetails->product_id = $request->product_id[$product_id];
                $returnDetails->unitprice = $request->price[$product_id];
                $returnDetails->quantity = $request->quantity[$product_id];
                $returnDetails->amount = $request->total_amount[$product_id];
                $returnDetails->save();
            }

            $returnData = SalesReturnProductDetails::where('sales_return_id', $salesReturn->transaction_id)
                ->get();

            foreach ($returnData as $value) {
                $update = OrderDetails::where('order_id', $request->order_id)
                    ->where('product_id', $value->product_id)
                    ->update([
                        'product_id' => $value->product_id, 'unitprice' => $value->unitprice,
                        'quantity' => $value->quantity, 'amount' => $value->amount
                    ]);
            }

            $data = OrderDetails::where('order_id', $request->order_id)->get();

            foreach ($data as $value) {
                $returnData = SalesReturnProductDetails::where('sales_return_id', $salesReturn->transaction_id)
                    ->where('product_id', $value->product_id)
                    ->count();

                if ($returnData == 0) {
                    $delete = OrderDetails::where('product_id', $value->product_id)->delete();
                }
            }

            $clearCart = SalesCart::query()->truncate();

            DB::commit();

            return view('sales.salesReturn', ['name' => $name, 'products' => $products, 'order_details' => $order_details, 'customer_orders' => $orderdBy]);
        } catch (\Exception $e) {
            return back()->with("Product orders Fails to inserted! check your inputs!");
        }
    }

    public function salesAccounts()
    {
        $accounts = SubAccounts::leftjoin('main_accounts', 'main_accounts.account_id', 'sub_accounts.parent_account_id')
            ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"), 'sub_accounts.transaction_id as value')
            ->where('degree', AccountType::Normal)
            ->get();

        $name = Auth::user()->user_name;
        return view('sales.salesAccounts', ['name' => $name, 'accounts' => $accounts]);
    }

    public function salesAccountsStore(Request $request)
    {
        $checkStatus = SalesAccountsSetup::where('account_type', $request->type)->count();

        if ($checkStatus == 0) {
            $setupSales = new SalesAccountsSetup();
            $setupSales->transaction_id = Transaction::setTransactionId();
            $setupSales->account_type = $request->type;
            $setupSales->account_id = $request->account;
            $setupSales->save();

            return redirect('salesAccounts')->with('message', $request->type . ' Added Successfully!');
        } else {
            $update = SalesAccountsSetup::where('account_type', $request->type)
                ->update(['account_id' => $request->account]);

            return redirect('salesAccounts')->with('message', $request->type . ' Updated Successfully!');
        }
    }

    public function dailySaleClose(Request $request)
    {
        $saleCloseStatus = Order::where('close_status', SaleCloseStatus::pending)->count();

        if ($saleCloseStatus != 0) {
            //sum of cash sale amount taxless
            $cashSale = Order::leftjoin('order_transactions', 'order_transactions.order_id', 'orders.id')
                ->leftjoin('order_details', 'order_details.order_id', 'orders.id')
                ->where('orders.close_status', SaleCloseStatus::pending)
                ->where('order_transactions.payment_method', 'cash')
                ->sum('order_details.amount');

            //sum of card sales amount taxless
            $cardSale = Order::leftjoin('order_transactions', 'order_transactions.order_id', 'orders.id')
                ->leftjoin('order_details', 'order_details.order_id', 'orders.id')
                ->where('orders.close_status', SaleCloseStatus::pending)
                ->where('order_transactions.payment_method', 'card')
                ->sum('order_details.amount');

            $totalTax = 000;

            $cashAccount = SalesAccountsSetup::where('account_type', 'cash')->value('account_id');

            $cardAccount = SalesAccountsSetup::where('account_type', 'card')->value('account_id');

            $revenueAccount = SalesAccountsSetup::where('account_type', 'revenue')->value('account_id');

            $tax = SalesAccountsSetup::where('account_type', 'tax')->value('account_id');

            //sales effect on accounts
            if (isset($cashSale)) {
                //cash sale
                $transaction1 = new TransactionDetails();
                $transaction1->transaction_id = Transaction::setTransactionId();
                $transaction1->type = TransactionType::sale;
                $transaction1->credit_account = $revenueAccount;
                $transaction1->debit_account = $cashAccount;
                $transaction1->amount = $cashSale;
                $transaction1->bill_no = null;
                $transaction1->narration = Carbon::now()->format('d-F-Y') . ' Cash Sales';
                $transaction1->date = Carbon::today();
                $transaction1->save();
            } elseif (isset($cardSale)) {
                //card sale
                $transaction1 = new TransactionDetails();
                $transaction1->transaction_id = Transaction::setTransactionId();
                $transaction1->type = TransactionType::sale;
                $transaction1->credit_account = $revenueAccount;
                $transaction1->debit_account = $cardAccount;
                $transaction1->amount = $cardSale;
                $transaction1->bill_no = null;
                $transaction1->narration = Carbon::now()->format('d-F-Y') . ' Card Sales';
                $transaction1->date = Carbon::today();
                $transaction1->save();
            }

            $saleCloseUpdate = Order::where('close_status', SaleCloseStatus::pending)
                ->update(['close_status' => SaleCloseStatus::closed]);
        }
        return redirect()->back();
    }

    public function salesRestaurant()
    {
        $name = Auth::user()->user_name;

        $todaysSale = RestSale::whereDay('created_at', now()->day)
            ->select(
                'bill_no',
                'payment_method',
                'sale_type',
                'total_amount',
                DB::raw('DATE_FORMAT(created_at, "%H:%i:%s") as time'),
                'payment_status'
            )
            ->latest()->get();

        $pendingSale = RestSale::where('payment_status', 0)
            ->select(
                'bill_no',
                'payment_method',
                'sale_type',
                'total_amount',
                DB::raw('DATE_FORMAT(created_at, "%H:%i:%s") as time'),
                DB::raw('DATE_FORMAT(created_at, "%d-%M-%Y") as date'),
                'payment_status'
            )
            ->latest()->get();

        $totalSale = RestSale::where('close_status', SaleCloseStatus::pending)
            ->where('payment_status', 1)
            ->sum('total_amount');

        $table = DineInTable::all();

        $takeAway = TakeAwaySale::latest()->where('created_at', '>', Carbon::now()->subHours(4)->toDateTimeString())->get();

        $deliveryList = DeliverySale::latest()->where('status', 0)
            ->where('created_at', '>', Carbon::now()->subHours(4)->toDateTimeString())->get();

        return view('sales.salesRestaurant', [
            'name' => $name, 'todaysSale' => $todaysSale, 'table' => $table,
            'takeAway' => $takeAway, 'delivery' => $deliveryList, 'total' => $totalSale, 'pendingSale' => $pendingSale
        ]);
    }

    public function clearItemCart()
    {
        $cart = ItemsCart::truncate();

        return redirect()->back();
    }

    public function storeSalesRestaurant()
    {
        $priceTotal = ItemsCart::sum('total_price');

        $cart = ItemsCart::first();

        $storeSale = new RestSale();
        $storeSale->transaction_id = Transaction::setTransactionId();
        $storeSale->bill_no = mt_rand(1000, 9999);;
        $storeSale->total_amount = $priceTotal;
        $storeSale->sale_type = $cart->sale_type;
        $storeSale->barcode = mt_rand(1000000, 9999999);;
        $storeSale->save();

        $listItems = ItemsCart::all();

        foreach ($listItems as $item) {
            $saleItems = new RestSaleItem();
            $saleItems->transaction_id = Transaction::setTransactionId();
            $saleItems->sale_id = $storeSale->transaction_id;
            $saleItems->product_id = $item->item_id;
            $saleItems->product_name = $item->item_name;
            $saleItems->quantity = $item->quantity;
            $saleItems->unit_price = $item->price;
            $saleItems->total_amount = $item->total_price;
            $saleItems->save();
        }

        $clearCart = ItemsCart::truncate();
        return redirect()->back();
    }

    public function dineTableList()
    {
        $name = Auth::user()->user_name;

        $tables = DineInTable::all();

        return view('sales.dineTable', ['name' => $name, 'tables' => $tables]);
    }

    public function storeDineTable(Request $request)
    {
        $dineTable = new DineInTable();
        $dineTable->transaction_id = Transaction::setTransactionId();
        $dineTable->table_name = $request->tableName;
        $dineTable->table_no = $request->tableNumber;
        $dineTable->save();

        Alert::success('Success', 'Table Created Successfully');
        return redirect()->back();
    }

    public function storeDineOrder($id)
    {
        $cartCheck = ItemsCart::count();

        if ($cartCheck == 0) {
            return redirect()->back();
        }

        $update = ItemsCart::where('status', 0)->update(['table_no' => $id, 'sale_type' => 'DINE IN']);

        $updateTableStatus = DineInTable::where('table_no', $id)
            ->update(['engaged_status' => 1]);

        $kitchenOrder = new KitchenOrder;
        $kitchenOrder->transaction_id = Transaction::setTransactionId();
        $kitchenOrder->order_type = 'Dine In ';
        $kitchenOrder->token_no = 0;
        $kitchenOrder->table_no =  $id;
        $kitchenOrder->save();

        $saleCart = ItemsCart::all();

        //store table items
        foreach ($saleCart as $cart) {

            $checkAvailable = DineInTableItems::where('item_id',$cart->item_id)->count();

            if($checkAvailable==0)
            {
                $tableItem = new DineInTableItems();
                $tableItem->table_id = $id;
                $tableItem->item_id = $cart->item_id;
                $tableItem->quantity = $cart->quantity;
                $tableItem->save();    
            }else{
                $update = DineInTableItems::where('item_id',$cart->item_id)
                ->increment('quantity', $cart->quantity);
            }
           
            $items = Items::where('transaction_id', $cart->item_id)->first();

            $kitchenOrderItems = new KitchenOrderItems;
            $kitchenOrderItems->transaction_id = Transaction::setTransactionId();
            $kitchenOrderItems->order_type = 'Dine In ';
            $kitchenOrderItems->kitchen_order_id = $kitchenOrder->transaction_id;
            $kitchenOrderItems->token_no = 0;
            $kitchenOrderItems->item_name = $items->item_name;
            $kitchenOrderItems->item_code = $items->item_code;
            $kitchenOrderItems->table_no =  $id;
            $kitchenOrderItems->quantity = $cart->quantity;
            $kitchenOrderItems->save();
        }

        $truncate = ItemsCart::truncate();

        return redirect()->back();
    }

    public function customerInvoiceCancel(Request $request)
    {
        $updateEngageStatus = DineInTable::where('table_no', $request->tableNo)
            ->update(['engaged_status' => 0]);

        $listItems = DineInTableItems::where('table_id', $request->tableNo)->truncate();

        $kitchen = KitchenOrderItems::where('table_no', $request->tableNo)->delete();

        $kitchen = KitchenOrder::where('table_no', $request->tableNo)->delete();

        return redirect()->back();
    }

    public function takeAwaySale(Request $request)
    {
        return $sale = RestSale::where('created_at', '>', Carbon::now()->subHours(1)->toDateTimeString())->get();
    }

    public function takeAway()
    {
        $cartCheck = ItemsCart::count();

        if ($cartCheck == 0) {
            return redirect()->back();
        }

        $total = ItemsCart::sum('total_price');

        $takeAwayStore = new TakeAwaySale();
        $takeAwayStore->transaction_id = Transaction::setTransactionId();
        $takeAwayStore->token_no = mt_rand(1000, 9999);
        $takeAwayStore->total_amount = $total;
        $takeAwayStore->save();

        $kitchenOrder = new KitchenOrder;
        $kitchenOrder->transaction_id = Transaction::setTransactionId();
        $kitchenOrder->order_type = 'Take Away';
        $kitchenOrder->token_no = $takeAwayStore->token_no;
        $kitchenOrder->save();

        $salesCart = ItemsCart::all();

        foreach ($salesCart as $cart) {
            $items = new TakeAwayItems();
            $items->take_id = $takeAwayStore->transaction_id;
            $items->token_no = $takeAwayStore->token_no;
            $items->item_id = $cart->item_id;
            $items->quantity = $cart->quantity;
            $items->save();

            $item = Items::where('transaction_id', $cart->item_id)->first();

            $kitchenOrderItems = new KitchenOrderItems;
            $kitchenOrderItems->transaction_id = Transaction::setTransactionId();
            $kitchenOrderItems->order_type = 'Take Away';
            $kitchenOrderItems->kitchen_order_id = $kitchenOrder->transaction_id;
            $kitchenOrderItems->token_no = $takeAwayStore->token_no;
            $kitchenOrderItems->item_name = $item->item_name;
            $kitchenOrderItems->item_code = $item->item_code;
            $kitchenOrderItems->quantity = $cart->quantity;
            $kitchenOrderItems->save();
        }

        $truncate = ItemsCart::truncate();

        return redirect()->back();
    }

    public function takeAwayOrderCancel(Request $request)
    {
        $cancelTakeAway = TakeAwaySale::where('token_no', $request->tokenNo)->delete();

        $listItems = TakeAwayItems::where('token_no', $request->tokenNo)->delete();

        $kitchen = KitchenOrderItems::where('token_no', $request->tokenNo)->delete();

        $kitchen = KitchenOrder::where('token_no', $request->tokenNo)->delete();

        return redirect()->back();
    }

    public function deliveryStore(Request $request)
    {
        $cartCheck = ItemsCart::count();

        if ($cartCheck == 0) {
            return redirect()->back();
        }

        $cartTotal = ItemsCart::sum('total_price');

        $delivery = new DeliverySale();
        $delivery->transaction_id = Transaction::setTransactionId();
        $delivery->token_no = mt_rand(1000, 9999);
        $delivery->customer = $request->customerName;
        $delivery->phone = $request->customerPhone;
        $delivery->address = $request->address;
        $delivery->total_price = $cartTotal;
        $delivery->save();

        $kitchenOrder = new KitchenOrder;
        $kitchenOrder->transaction_id = Transaction::setTransactionId();
        $kitchenOrder->order_type = 'Delivery';
        $kitchenOrder->token_no = $delivery->token_no;
        $kitchenOrder->save();

        $carts = ItemsCart::all();

        foreach ($carts as $value) {
            $deliveyItems = new DeliverySaleItems();
            $deliveyItems->delivery_id = $delivery->transaction_id;
            $deliveyItems->token_no = $delivery->token_no;
            $deliveyItems->item_id = $value->item_id;
            $deliveyItems->quantity = $value->quantity;
            $deliveyItems->save();

            $item = Items::where('transaction_id', $value->item_id)->first();

            $kitchenOrderItems = new KitchenOrderItems;
            $kitchenOrderItems->transaction_id = Transaction::setTransactionId();
            $kitchenOrderItems->kitchen_order_id = $kitchenOrder->transaction_id;
            $kitchenOrderItems->order_type = 'Delivery';
            $kitchenOrderItems->token_no = $deliveyItems->token_no;
            $kitchenOrderItems->item_name = $item->item_name;
            $kitchenOrderItems->item_code = $item->item_code;
            $kitchenOrderItems->quantity = $value->quantity;
            $kitchenOrderItems->save();
        }

        $truncate = ItemsCart::truncate();

        return redirect()->back();
    }

    public function deliveryOrderCancel(Request $request)
    {
        $deliveryOrderCancel = DeliverySale::where('token_no', $request->tokenNo)->delete();

        $listItems = DeliverySaleItems::where('token_no', $request->tokenNo)->delete();

        $kitchen = KitchenOrderItems::where('token_no', $request->tokenNo)->delete();

        $kitchen = KitchenOrder::where('token_no', $request->tokenNo)->delete();

        return redirect()->back();
    }

    public function takeAwaySaleStore(Request $request)
    {
        //generate take away bill for customer
        $checkAlreadyExist = RestSale::where('take_away_sales.token_no', $request->id)
            ->leftjoin('take_away_sales', 'rest_sales.sale_type_id', 'take_away_sales.transaction_id')
            ->count();

        if ($checkAlreadyExist != 0) {
            //print reciept code
            return redirect()->back();
        }

        //delete ordertable
        $clearOrder = KitchenOrder::where('token_no', $request->id)->delete();

        $clearDetails = KitchenOrderItems::where('token_no', $request->id)->delete();

        $totalPrice = TakeAwaySale::where('token_no', $request->id)->first();

        $storeSale = new RestSale();
        $storeSale->transaction_id = Transaction::setTransactionId();
        $storeSale->bill_no = $request->id;
        $storeSale->total_amount = $totalPrice->total_amount;
        $storeSale->sale_type = 'TAKE AWAY';
        $storeSale->sale_type_id = $totalPrice->transaction_id;
        $storeSale->barcode = mt_rand(1000000, 9999999);;
        $storeSale->save();

        $listItems = TakeAwayItems::where('take_away_items.token_no', $request->id)
            ->leftjoin('items', 'items.transaction_id', 'take_away_items.item_id')
            ->select('items.item_name', 'take_away_items.item_id', 'take_away_items.quantity', 'items.amount')
            ->get();

        foreach ($listItems as $item) {
            $saleItems = new RestSaleItem();
            $saleItems->transaction_id = Transaction::setTransactionId();
            $saleItems->sale_id = $storeSale->transaction_id;
            $saleItems->product_id = $item->item_id;
            $saleItems->product_name = $item->item_name;
            $saleItems->quantity = $item->quantity;
            $saleItems->unit_price = $item->amount;
            $saleItems->total_amount = $item->quantity * $item->amount;
            $saleItems->save();
        }

        //print receipt
        return redirect()->route('printBill',['saleId'=>$storeSale->transaction_id]);
    }

    public function customerInvoicePrint(Request $request)
    {
        //Print Bill For Dine In Customer

        $checkAvailableStatus = DineInTable::where('table_no', $request->id)
            ->where('engaged_status', 0)
            ->count();

        if ($checkAvailableStatus != 0) {
            return redirect()->back();
        }

        //delete ordertable
        $clearOrder = KitchenOrder::where('table_no', $request->id)->delete();

        $clearDetails = KitchenOrderItems::where('table_no', $request->id)->delete();

        $dineInTable = DineInTable::where('table_no', $request->id)->value('transaction_id');

        $storeSale = new RestSale();
        $storeSale->transaction_id = Transaction::setTransactionId();
        $storeSale->bill_no = mt_rand(1000, 9999);
        $storeSale->total_amount = 0;
        $storeSale->sale_type = 'DINE IN';
        $storeSale->sale_type_id = $dineInTable;
        $storeSale->table_no = $request->id;
        $storeSale->barcode = mt_rand(1000000, 9999999);
        $storeSale->save();

        $listItems = DineInTableItems::leftjoin('items', 'items.transaction_id', 'dine_in_table_items.item_id')
            ->where('table_id', $request->id)
            ->select('items.item_name', 'items.transaction_id as item_id', 'dine_in_table_items.quantity', 'items.amount')
            ->get();


        foreach ($listItems as $item) {
            $saleItems = new RestSaleItem();
            $saleItems->transaction_id = Transaction::setTransactionId();
            $saleItems->sale_id = $storeSale->transaction_id;
            $saleItems->product_id = $item->item_id;
            $saleItems->product_name = $item->item_name;
            $saleItems->quantity = $item->quantity;
            $saleItems->unit_price = $item->amount;
            $saleItems->total_amount = $item->quantity * $item->amount;
            $saleItems->save();
        }

        $sum = RestSaleItem::where('sale_id', $storeSale->transaction_id)
            ->sum('total_amount');

        $updateTotalPrice = RestSale::where('status', 0)->update(['total_amount' => $sum]);

        $updateEngageStatus = DineInTable::where('table_no', $request->id)
            ->update(['engaged_status' => 0]);

        $truncate = DineInTableItems::truncate();
        

        // return 'Print Customer Invoice';

        return redirect()->route('printBill',['saleId'=>$storeSale->transaction_id]);

    }

    public function deliverySaleStore(Request $request)
    {
        //generate Bill For Customer
        $checkAlreadyExist = RestSale::where('delivery_sales.token_no', $request->tokenNo)
            ->leftjoin('delivery_sales', 'rest_sales.sale_type_id', 'delivery_sales.transaction_id')
            ->count();

        if($checkAlreadyExist!=0)
        {
          //print reciept code
          return redirect()->back();
        }
        //delete ordertable
        $clearOrder = KitchenOrder::where('token_no', $request->tokenNo)->delete();

        $clearDetails = KitchenOrderItems::where('token_no', $request->tokenNo)->delete();

        $totalPrice = DeliverySale::where('token_no', $request->tokenNo)->first();

        $storeSale = new RestSale();
        $storeSale->transaction_id = Transaction::setTransactionId();
        $storeSale->bill_no = $request->tokenNo;
        $storeSale->total_amount = $totalPrice->total_price;
        $storeSale->sale_type = 'DELIVERY';
        $storeSale->sale_type_id = $totalPrice->transaction_id;
        $storeSale->barcode = mt_rand(1000000, 9999999);;
        $storeSale->save();

        $listItems = DeliverySaleItems::where('delivery_sale_items.token_no',$request->tokenNo)
            ->leftjoin('items', 'items.transaction_id', 'delivery_sale_items.item_id')
            ->select('items.item_name', 'delivery_sale_items.item_id', 'delivery_sale_items.quantity', 'items.amount')
            ->get();

        foreach ($listItems as $item) {

            $saleItems = new RestSaleItem();
            $saleItems->transaction_id = Transaction::setTransactionId();
            $saleItems->sale_id = $storeSale->transaction_id;
            $saleItems->product_id = $item->item_id;
            $saleItems->product_name = $item->item_name;
            $saleItems->quantity = $item->quantity;
            $saleItems->unit_price = $item->amount;
            $saleItems->total_amount = $item->quantity * $item->amount;
            $saleItems->save();
        }

        //print receipt
        return redirect()->route('printBill',['saleId'=>$storeSale->transaction_id]);
    }

    public function restaurantSalesReport(Request $request)
    {
        $totalPercentage = 0;
        $totalRevenue = 0;

        if ($request->type == 'daily') {

            $dailyReport = RestSale::select(
                DB::raw('DATE_FORMAT(created_at, "%H:%i:%s") as time'),
                DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as date'),
                'rest_sales.*'
            )
                ->whereDay('created_at', now()->day)
                ->latest()->get();

            foreach ($dailyReport as $value) {
                if ($value->total_amount >= 5) {
                    $total = $value->total_amount;

                    $percentage = (5 / 100) * $total;

                    $value->percentage = $percentage;

                    $value->revenue = $total - $percentage;

                    $totalPercentage += $value->percentage;
                    $totalRevenue += $value->revenue;
                } else {
                    $value->percentage = 0;

                    $value->revenue = $value->total_amount;

                    $totalPercentage += $value->percentage;
                    $totalRevenue += $value->revenue;
                }
            }

            $today = Carbon::now()->format('d-F-Y');

            $totalSale = $dailyReport->sum('total_amount');

            $pdf = PDF::loadView('sales.restaurantSalesReport', [
                'today' => $today, 'total' => $totalSale,
                'report' => $dailyReport, 'type' => $request->type, 'totalPercentage' => $totalPercentage, 'totalRevenue' => $totalRevenue
            ]);

            //  download PDF file with download method
            return $pdf->download('DailyReport.pdf');
        } elseif ($request->type == 'weekly') {
            $from = Carbon::now()->startOfWeek()->format('d-F-Y');
            $to = Carbon::now()->endOfWeek()->format('d-F-Y');

            $weeklyReport = RestSale::select(
                DB::raw('DATE_FORMAT(created_at, "%H:%i:%s") as time'),
                DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as date'),
                'rest_sales.*'
            )
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->latest()->get();

            foreach ($weeklyReport as $value) {
                if ($value->total_amount >= 5) {
                    $total = $value->total_amount;

                    $percentage = (5 / 100) * $total;

                    $value->percentage = $percentage;

                    $value->revenue = $total - $percentage;

                    $totalPercentage += $value->percentage;
                    $totalRevenue += $value->revenue;
                } else {
                    $value->percentage = 0;

                    $value->revenue = $value->total_amount;

                    $totalPercentage += $value->percentage;
                    $totalRevenue += $value->revenue;
                }
            }

            $today = Carbon::now()->format('d-F-Y');

            $totalSale = $weeklyReport->sum('total_amount');

            $pdf = PDF::loadView('sales.restaurantSalesReport', [
                'today' => $today, 'total' => $totalSale,
                'report' => $weeklyReport, 'type' => $request->type, 'totalPercentage' => $totalPercentage,
                'totalRevenue' => $totalRevenue, 'from' => $from, 'to' => $to
            ]);

            //  download PDF file with download method
            return $pdf->download('WeeklyReport.pdf');
        } elseif ($request->type == 'monthly') {
            $month = Carbon::now()->format('F');

            $monthlyReport = RestSale::select(
                DB::raw('DATE_FORMAT(created_at, "%H:%i:%s") as time'),
                DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as date'),
                'rest_sales.*'
            )
                ->whereMonth('created_at', Carbon::now()->month)
                ->latest()->get();

            foreach ($monthlyReport as $value) {
                if ($value->total_amount >= 5) {
                    $total = $value->total_amount;

                    $percentage = (5 / 100) * $total;

                    $value->percentage = $percentage;

                    $value->revenue = $total - $percentage;

                    $totalPercentage += $value->percentage;
                    $totalRevenue += $value->revenue;
                } else {
                    $value->percentage = 0;

                    $value->revenue = $value->total_amount;

                    $totalPercentage += $value->percentage;
                    $totalRevenue += $value->revenue;
                }
            }

            $today = Carbon::now()->format('d-F-Y');

            $totalSale = $monthlyReport->sum('total_amount');

            $pdf = PDF::loadView('sales.restaurantSalesReport', [
                'today' => $today, 'total' => $totalSale,
                'report' => $monthlyReport, 'type' => $request->type, 'totalPercentage' => $totalPercentage,
                'totalRevenue' => $totalRevenue, 'month' => $month
            ]);

            //  download PDF file with download method
            return $pdf->download('MonthlyReport.pdf');
        } else {
            $fromDate = date('Y-m-d', strtotime($request->fromDate)) . ' 00:00:00';
            $toDate = date('Y-m-d', strtotime($request->toDate)) . ' 23:59:59';

            $from = date('d-M-Y', strtotime($request->fromDate));

            $to = date('d-M-Y', strtotime($request->toDate));

            $report = RestSale::select(
                DB::raw('DATE_FORMAT(created_at, "%H:%i:%s") as time'),
                DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as date'),
                'rest_sales.*'
            )
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->latest()->get();

            foreach ($report as $value) {
                if ($value->total_amount >= 5) {
                    $total = $value->total_amount;

                    $percentage = (5 / 100) * $total;

                    $value->percentage = $percentage;

                    $value->revenue = $total - $percentage;

                    $totalPercentage += $value->percentage;
                    $totalRevenue += $value->revenue;
                } else {
                    $value->percentage = 0;

                    $value->revenue = $value->total_amount;

                    $totalPercentage += $value->percentage;
                    $totalRevenue += $value->revenue;
                }
            }

            $today = Carbon::now()->format('d-F-Y');

            $totalSale = $report->sum('total_amount');

            $pdf = PDF::loadView('sales.restaurantSalesReport', [
                'today' => $today, 'total' => $totalSale,
                'report' => $report, 'type' => $request->type, 'totalPercentage' => $totalPercentage,
                'totalRevenue' => $totalRevenue, 'from' => $from, 'to' => $to
            ]);

            //  download PDF file with download method
            return $pdf->download('Report.pdf');
        }
    }

    public function salesRestaurantSetup()
    {
        $name = Auth::user()->user_name;

        $accounts = SubAccounts::leftjoin('main_accounts', 'main_accounts.account_id', 'sub_accounts.parent_account_id')
            ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"), 'sub_accounts.transaction_id as value')
            ->where('degree', AccountType::Normal)
            ->get();

        $cash =  SalesAccountsSetup::where('restaurant_status', 1)
            ->where('account_type', 'cash')
            ->value('account_id');

        $card =  SalesAccountsSetup::where('restaurant_status', 1)
            ->where('account_type', 'card')
            ->value('account_id');

        $revenue =  SalesAccountsSetup::where('restaurant_status', 1)
            ->where('account_type', 'revenue')
            ->value('account_id');

        $tax =  SalesAccountsSetup::where('restaurant_status', 1)
            ->where('account_type', 'tax')
            ->value('account_id');

        return view('sales.salesRestaurantSetup', [
            'name' => $name, 'accounts' => $accounts, 'cash' => $cash, 'card' => $card,
            'revenue' => $revenue, 'tax' => $tax
        ]);
    }

    public function restaurantSetupStore(Request $request)
    {
        if (!isset($request->account)) {
            return redirect()->back();
        }

        $checkStatus = SalesAccountsSetup::where('account_type', $request->type)
            ->where('restaurant_status', 1)
            ->count();

        if ($checkStatus == 0) {
            $setupSales = new SalesAccountsSetup();
            $setupSales->transaction_id = Transaction::setTransactionId();
            $setupSales->account_type = $request->type;
            $setupSales->account_id = $request->account;
            $setupSales->restaurant_status = 1;
            $setupSales->save();

            return redirect()->back()->with('message', $request->type . ' Added Successfully!');
        } else {
            $update = SalesAccountsSetup::where('account_type', $request->type)
                ->where('restaurant_status', 1)
                ->update(['account_id' => $request->account]);

            return redirect()->back()->with('message', $request->type . ' Updated Successfully!');
        }
    }

    public function restaurantSaleClose()
    {
        $saleCloseStatus = RestSale::where('close_status', SaleCloseStatus::pending)->count();

        if ($saleCloseStatus != 0) {
            //sum of cash sale amount taxles
            $cashSale = RestSale::where('close_status', SaleCloseStatus::pending)
                ->where('payment_method', 'cash')
                ->sum('total_amount');

            //sum of card sales amount taxles
            $cardSale = RestSale::where('close_status', SaleCloseStatus::pending)
                ->where('payment_method', 'card')
                ->sum('total_amount');

            $totalTax = 000;

            $cashAccount = SalesAccountsSetup::where('account_type', 'cash')
                ->where('restaurant_status', 1)
                ->value('account_id');

            $cardAccount = SalesAccountsSetup::where('account_type', 'card')
                ->where('restaurant_status', 1)
                ->value('account_id');

            $revenueAccount = SalesAccountsSetup::where('account_type', 'revenue')
                ->where('restaurant_status', 1)
                ->value('account_id');

            $tax = SalesAccountsSetup::where('account_type', 'tax')
                ->where('restaurant_status', 1)
                ->value('account_id');

            //calculate tax(5%)VAT
            $vatCalc = RestSale::where('close_status', SaleCloseStatus::pending)
                ->where('total_amount', '>=', 5)
                ->where('payment_method', 'cash')
                ->sum('total_amount');

            //cash
            $VAT = 5;
            $totalSaleCash = $vatCalc;

            $taxAmountCash = ($VAT / 100) * $totalSaleCash;

            $taxLessCashTotal = $cashSale - $taxAmountCash;

            $vatCalcCard = RestSale::where('close_status', SaleCloseStatus::pending)
                ->where('total_amount', '>=', 5)
                ->where('payment_method', 'card')
                ->sum('total_amount');

            //card
            $totalSaleCard = $vatCalcCard;

            $taxAmountCard = ($VAT / 100) * $totalSaleCard;

            $taxLessCardTotal = $cardSale - $taxAmountCard;

            //sales effect on accounts
            if ($cashSale != 0) {
                //cash sale
                $transaction1 = new TransactionDetails();
                $transaction1->transaction_id = Transaction::setTransactionId();
                $transaction1->type = TransactionType::sale;
                $transaction1->credit_account = $revenueAccount;
                $transaction1->debit_account = $cashAccount;
                $transaction1->amount = $taxLessCashTotal;
                $transaction1->bill_no = null;
                $transaction1->narration = Carbon::now()->format('d-F-Y') . ' Cash Sales';
                $transaction1->date = Carbon::today();
                $transaction1->save();

                if ($taxAmountCash != 0) {
                    //tax store
                    $cashSaleTax = new TransactionDetails();
                    $cashSaleTax->transaction_id = Transaction::setTransactionId();
                    $cashSaleTax->type = TransactionType::sale;
                    $cashSaleTax->credit_account = $tax;
                    $cashSaleTax->debit_account = $cashAccount;
                    $cashSaleTax->amount = $taxAmountCash;
                    $cashSaleTax->bill_no = null;
                    $cashSaleTax->narration = Carbon::now()->format('d-F-Y') . ' Cash Sales Tax(5%)';
                    $cashSaleTax->date = Carbon::today();
                    $cashSaleTax->save();
                }
            } elseif ($cardSale != 0) {
                //card sale
                $transaction1 = new TransactionDetails();
                $transaction1->transaction_id = Transaction::setTransactionId();
                $transaction1->type = TransactionType::sale;
                $transaction1->credit_account = $revenueAccount;
                $transaction1->debit_account = $cardAccount;
                $transaction1->amount = $taxLessCardTotal;
                $transaction1->bill_no = null;
                $transaction1->narration = Carbon::now()->format('d-F-Y') . ' Card Sales';
                $transaction1->date = Carbon::today();
                $transaction1->save();

                //tax store
                $cardSaleTax = new TransactionDetails();
                $cardSaleTax->transaction_id = Transaction::setTransactionId();
                $cardSaleTax->type = TransactionType::sale;
                $cardSaleTax->credit_account = $tax;
                $cardSaleTax->debit_account = $cardAccount;
                $cardSaleTax->amount = $taxAmountCard;
                $cardSaleTax->bill_no = null;
                $cardSaleTax->narration = Carbon::now()->format('d-F-Y') . ' Card Sales Tax(5%)';
                $cardSaleTax->date = Carbon::today();
                $cardSaleTax->save();
            }

            $saleCloseUpdate = RestSale::where('close_status', SaleCloseStatus::pending)
                ->update(['close_status' => SaleCloseStatus::closed]);

            //truncate tables 
            $truncate = TakeAwaySale::truncate();
            TakeAwayItems::truncate();
            DeliverySale::truncate();
            DeliverySaleItems::truncate();
        }

        //Kitchen Order table clear
        $truncate = KitchenOrder::truncate();

        return redirect()->back();
    }

    public function salesMainReports()
    {
        $name = Auth::user()->user_name;

        return view('sales.salesMainReports', ['name' => $name]);
    }

    public function demoTestPage()
    {
        return view('demoTestPage', ['name' => Auth::user()->user_name]);
    }

    public function drawerOpen()
    {
        $connector = null;
        $connector = new WindowsPrintConnector("SGT-88IV");
        $printer = new Printer($connector);

        //for open cash drawer
        $printer->pulse();

        $printer->close();

        return redirect()->back();
    }
}
