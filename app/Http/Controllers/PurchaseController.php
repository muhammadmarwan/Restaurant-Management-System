<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\SubAccounts;
use App\Models\PurchaseEntry;
use App\Models\TransactionDetails;
use Illuminate\Support\Facades\DB;
use Auth;
use App\TransactionId\Transaction;
use App\Common\PaymentStatus;
use App\Common\AccountType;
use App\Models\Product;
use App\Models\PurchaseInventoryCart;
use App\Models\PurchaseInventoryOrder;
use App\Models\PurchaseInventoryProducts;
use App\Common\TransactionType;
use PDF;
use Carbon\Carbon;
use App\Models\PurchaseReturn;
use App\Models\PurchaseSetup;
use App\Models\ProductQuantityUnit;
use RealRashid\SweetAlert\Facades\Alert;

class PurchaseController extends Controller
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
    public function purchaseEntryPage()
    {
        $vendor = Vendor::where('status',0)->select('name as label','transaction_id as value')->get();
        
        $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->get();

        $name = Auth::user()->user_name;

        return view('purchase.purchaseEntry',['name'=>$name,'vendor'=>$vendor,'accounts'=>$accounts]);
    }

    public function purchaseEntryStore(Request $request)
    {
        $this->validate(request(), [
            'vendorId' => 'required',
            'accountId' => 'required',
            'due_date' => 'required',
            'invoiceNo' => 'required',
            'description' => 'required',
        ]);
        
        $fourRandomDigit = rand(1000,9999);
        $billNo = $fourRandomDigit;

        $amountTotal = $request->amount;
        // calcualte VAT
        $tax = (5 / 100) * $amountTotal;

        if($amountTotal<5)
        {
            $tax=0;
        }

        $vendorAccount = SubAccounts::where('account_code',$request->vendorId)
        ->select('transaction_id as accountNumber')->first();

        try {
            //create transaction
            $transaction = new TransactionDetails();
            $transaction->transaction_id = Transaction::setTransactionId();
            $transaction->type = TransactionType::purchase;
            $transaction->credit_account = $vendorAccount->accountNumber;
            $transaction->debit_account = $request->accountId;
            $transaction->amount = $amountTotal - $tax;
            $transaction->bill_no = $request->invoiceNo;
            $transaction->narration = $request->description;
            $transaction->date = $request->purchaseDate;
            $transaction->unique_id = $billNo;
            $transaction->save();

            $taxAccount = PurchaseSetup::where('id',1)->value('account_id');

            //create transaction Vat Tax
            $transaction1 = new TransactionDetails();
            $transaction1->transaction_id = Transaction::setTransactionId();
            $transaction1->type = TransactionType::purchase;
            $transaction1->credit_account = $vendorAccount->accountNumber;
            $transaction1->debit_account = $taxAccount;
            $transaction1->amount = $tax;
            $transaction1->bill_no = $request->invoiceNo;
            $transaction1->narration = $request->description.' (Purchase Tax)';
            $transaction1->date = $request->purchaseDate;
            $transaction1->unique_id = $billNo;
            $transaction1->save();

            $payableAccount = SubAccounts::where('account_code',9090)->first();

            //accounts payable
            $transaction2 = new TransactionDetails();
            $transaction2->transaction_id = $transaction->transaction_id;
            $transaction2->type = TransactionType::payableAccount;
            $transaction2->credit_account = $payableAccount->transaction_id;
            $transaction2->debit_account = '';
            $transaction2->amount = $amountTotal;
            $transaction2->bill_no = $request->invoiceNo;
            $transaction2->narration = $request->description;
            $transaction2->date = $request->purchaseDate;
            $transaction2->unique_id = $billNo;
            $transaction2->save();
            
            //create purchase entry
            $purchase = new PurchaseEntry();
            $purchase->transaction_id = Transaction::setTransactionId();
            $purchase->vendor_id = $request->vendorId;
            $purchase->vendor_account_no = $vendorAccount->accountNumber;
            $purchase->debit_account_no = $request->accountId;
            $purchase->net_amount = $amountTotal - $tax;
            $purchase->tax = $tax;
            $purchase->amount = $amountTotal;
            $purchase->bill_no = $billNo;
            $purchase->invoice_no = $request->invoiceNo;
            $purchase->due_date = date('d-m-Y', strtotime($request->due_date));
            $purchase->description = $request->description;
            $purchase->transaction_details_id = $transaction1->transaction_id;
            $purchase->save();

            return redirect('purchaseHistory')->with('message', 'Purchase Order Added Successfully!');        
         
        }            
        catch (Exception $e){

            return json_encode(array("status" => 300));
        }      
    }

    public function purchaseInventoryViewPage()
    { 
        $name = Auth::user()->user_name;

        $vendor = Vendor::where('status',0)->select('name as label','transaction_id as value')->get();

        $products = Product::leftjoin('product_categories','product_categories.transaction_id','products.product_category_code')
        ->select(DB::raw("CONCAT(product_categories.category_name,'-',products.product_name,'(',products.product_code,')') AS label"),'products.transaction_id as value')
        ->where('products.status',0)
        ->orderBy('product_categories.category_name')
        ->get();

        $quantityUnits = ProductQuantityUnit::all();         

        $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->get();
 
        $productsCart = PurchaseInventoryCart::leftjoin('products','products.transaction_id','purchase_inventory_carts.product_id')
        ->select('products.product_name','products.product_code','purchase_inventory_carts.unit_price','purchase_inventory_carts.quantity',
        DB::raw('DATE_FORMAT(purchase_inventory_carts.expiry_date, "%d/%M/%Y") as expiry_date'))
        ->get();

        return view('purchase.purchaseInventory',['name'=>$name,'vendor'=>$vendor,'products'=>$products,
        'quantityUnits'=>$quantityUnits,'accounts'=>$accounts,'productsCart'=>$productsCart]);
    }

    // public function purchaseInventoryProductCart(Request $request)
    // {
    //     $cartStore = new PurchaseInventoryCart();
    //     $cartStore->transaction_id = Transaction::setTransactionId();
    //     $cartStore->product_id = $request->product;
    //     $cartStore->unit_price = $request->unitPrice;
    //     $cartStore->expiry_date = $request->expiryDate;
    //     $cartStore->quantity = $request->quantity;
    //     $cartStore->save();

    //     $date = date('d/M/Y', strtotime($request->expiryDate));

    //     $products = Product::where('transaction_id',$request->product)->first();
        
    //     $data['product'] = $products->product_name;
    //     $data['product_id'] = $products->product_code;
    //     $data['unit_price'] = $request->unitPrice;
    //     $data['expiry_date'] = $date;
    //     $data['quantity'] = $request->quantity;
    //     return response()->json($data);
    // }

    public function purchaseInventoryStore(Request $request)
    {

        $this->validate(request(), [
            'vendorId' => 'required',
            'accountId' => 'required',
            'due_date' => 'required',
            'invoiceNo' => 'required',
            'description' => 'required',
            'productName' => 'required', 
            'unit' => 'required',  
            'total' => 'required',  
        ]);

        $fourRandomDigit = rand(1000,9999);
        $billNo = $fourRandomDigit;

        $amountTotal = $request->amount;
        // calcualte VAT
        $tax = (5 / 100) * $amountTotal;

        if($amountTotal<5)
        {
            $tax=0;
        }

        $vendorAccount = SubAccounts::where('account_code',$request->vendorId)
        ->select('transaction_id as accountNumber')->first();

        //create transaction
        $transaction = new TransactionDetails();
        $transaction->transaction_id = Transaction::setTransactionId();
        $transaction->type = TransactionType::purchase;
        $transaction->credit_account = $vendorAccount->accountNumber;
        $transaction->debit_account = $request->accountId;
        $transaction->amount = $request->amount - $tax;
        $transaction->bill_no = $request->invoiceNo;
        $transaction->narration = $request->description;
        $transaction->date = $request->purchaseDate;
        $transaction->unique_id = $billNo;
        $transaction->save();

        $taxAccount = PurchaseSetup::where('id',1)->value('account_id');

        //create transaction Vat Tax
        $transaction1 = new TransactionDetails();
        $transaction1->transaction_id = Transaction::setTransactionId();
        $transaction1->type = TransactionType::purchase;
        $transaction1->credit_account = $vendorAccount->accountNumber;
        $transaction1->debit_account = $taxAccount;
        $transaction1->amount = $tax;
        $transaction1->bill_no = $request->invoiceNo;
        $transaction1->narration = $request->description.' (Purchase Tax)';
        $transaction1->date = $request->purchaseDate;
        $transaction1->unique_id = $billNo;
        $transaction1->save();

        $payableAccount = SubAccounts::where('account_code',9090)->first();

        //accounts payable
        $transaction2 = new TransactionDetails();
        $transaction2->transaction_id = $transaction->transaction_id;
        $transaction2->type = TransactionType::payableAccount;
        $transaction2->credit_account = $payableAccount->transaction_id;
        $transaction2->debit_account = '';
        $transaction2->amount = $request->amount;
        $transaction2->bill_no = $request->invoiceNo;
        $transaction2->narration = $request->description;
        $transaction2->date = $request->purchaseDate;
        $transaction2->unique_id = $billNo;
        $transaction2->save();

        $storeInventory = new PurchaseInventoryOrder();
        $storeInventory->transaction_id = Transaction::setTransactionId();
        $storeInventory->vendor_id = $request->vendorId;
        $storeInventory->bill_no = $billNo;
        $storeInventory->invoice_no = $request->invoiceNo;
        $storeInventory->due_date = date('d-m-Y', strtotime($request->due_date));
        $storeInventory->debit_account = $request->accountId; 
        $storeInventory->total_amount = $request->amount;
        $storeInventory->transaction_details_id = $transaction2->transaction_id;
        $storeInventory->description = $request->description;
        $storeInventory->save();

        for($product_id = 0; $product_id < count($request->productName); $product_id++)
        {

            $purchaseInventory = new PurchaseInventoryProducts();
            $purchaseInventory->transaction_id = Transaction::setTransactionId();
            $purchaseInventory->vendor_id = $request->vendorId;
            $purchaseInventory->order_id = $storeInventory->transaction_id;
            $purchaseInventory->product_id = $request->productName[$product_id];
            $purchaseInventory->quantity = $request->quantity[$product_id];
            $purchaseInventory->unit = $request->unit[$product_id];
            $purchaseInventory->total = $request->total[$product_id];
            $purchaseInventory->unit_price = $request->total[$product_id];
            $purchaseInventory->save();

            $updateStock = Product::where('transaction_id',$request->productName[$product_id])
            ->increment('stock',$request->quantity[$product_id]);
        }        
        return redirect('purchaseHistory')->with('message', 'Product Purchased Successfully!'); 
    }

    public function inventoryProducts(Request $request)
    {   
        if(!isset($request->product_id))
        {
            $inventory = PurchaseInventoryOrder::all();
            foreach($inventory as $val)
            {
                $check = PurchaseInventoryProducts::where('order_id',$val->transaction_id)->count();

                if($check==0)
                {
                    PurchaseInventoryOrder::where('transaction_id',$val->transaction_id)->delete();
                    TransactionDetails::where('transaction_id',$val->transaction_details_id)->delete();
                }
            }
            return redirect()->route('dashboard');
        }

        $vendorId = PurchaseInventoryOrder::where('transaction_id',$request->purchaseId)
        ->value('vendor_id');

        for($product_id = 0; $product_id < count($request->product_id); $product_id++)
        {
            $purchaseInventory = new PurchaseInventoryProducts();
            $purchaseInventory->transaction_id = Transaction::setTransactionId();
            $purchaseInventory->vendor_id = $vendorId;
            $purchaseInventory->order_id = $request->purchaseId;
            $purchaseInventory->product_id = $request->product_id[$product_id];
            $purchaseInventory->unit_price = $request->unitPrice[$product_id];
            $purchaseInventory->quantity = $request->quantity[$product_id];
            $purchaseInventory->expiry_date = $request->expiryDate[$product_id];
            $purchaseInventory->save();

            $stock = Product::where('transaction_id',$request->product_id[$product_id])
            ->value('stock');

            if(isset($stock))
            {
                $update = Product::where('transaction_id',$request->product_id[$product_id])
                ->update(['stock'=>$stock + $request->quantity[$product_id]]);
            }
        }        
        //clear cart
        $clearCart = PurchaseInventoryCart::truncate();

        return redirect('purchaseInventory')->with('message', 'Purchase Order Added Successfully!');

    }

    public function clearInventoryCart()
    {
        $clearCart = PurchaseInventoryCart::truncate();

        return redirect('purchaseInventory');
    }

    public function purchaseHistory()
    {
        $purchase = PurchaseEntry::leftjoin('vendors','vendors.transaction_id','purchase_entries.vendor_id')
        ->select('vendors.name as vendorName','purchase_entries.*')->get();

        $inventory = PurchaseInventoryOrder::leftjoin('vendors','vendors.transaction_id','purchase_inventory_orders.vendor_id')
        ->select('vendors.name as vendorName','purchase_inventory_orders.*','purchase_inventory_orders.total_amount as amount')->get();

        $array = [];
        foreach($purchase as $val)
        { 
            $val->type = 'Normal';

            array_push($array,$val);    
        }
        
        foreach($inventory as $val)
        {
            $val->type = 'Inventory';
        
            array_push($array,$val);
        }
        $name = Auth::user()->user_name;

        return view('purchase.purchaseHistory',['name'=>$name,'history'=>$array]);
    }

    public function printPurchaseBill(Request $request)
    {
        $purchaseCheck = PurchaseEntry::where('transaction_id',$request->date)->count();

        if($purchaseCheck!=0)
        {
            $purchase = PurchaseEntry::leftjoin('vendors','vendors.transaction_id','purchase_entries.vendor_id')
            ->select('vendors.name as vendorName','vendors.address as vendorAddress','vendors.country',
            'vendors.phone','vendors.email_id','purchase_entries.*')
            ->first();

            $product = [];
        }
        else
        {
            $purchase = PurchaseInventoryOrder::leftjoin('vendors','vendors.transaction_id','purchase_inventory_orders.vendor_id')
            ->select('vendors.name as vendorName','vendors.address as vendorAddress','vendors.country',
            'vendors.phone','vendors.email_id','purchase_inventory_orders.*','purchase_inventory_orders.total_amount as amount',
            'purchase_inventory_orders.transaction_id as orderId')
            ->first(); 

            $product = PurchaseInventoryProducts::leftjoin('products','products.transaction_id','purchase_inventory_products.product_id')
            ->where('purchase_inventory_products.order_id',$purchase->orderId)
            ->select('products.product_name','purchase_inventory_products.*')
            ->get();
    
        }

        $today = Carbon::now()->format('d-F-Y');

        $pdf = PDF::loadView('pdf.purchaseBill',['today'=>$today,'purchase'=>$purchase,'products'=>$product]);

        //  download PDF file with download method
        return $pdf->download('purchaseBill.pdf');
    }

    public function purchaseReturn()
    {

        $vendor = Vendor::where('status',0)->select('name as label','transaction_id as value')->get();
        
        $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->get();


        $name = Auth::user()->name;

        return view('purchase.purchaseReturn',['name'=>$name,'vendor'=>$vendor,'accounts'=>$accounts]);
    }

    public function purchaseReturnCheck(Request $request)
    {
        $this->validate(request(), [
            'purchaseId' => 'required',
            'invoiceNo' => 'required',
            'vendorId' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'narration' => 'required', 
           
        ]);

        $purchaseCount = PurchaseEntry::where('transaction_id',$request->purchaseId)->count();

        $purchaseReturn = new PurchaseReturn();
        $purchaseReturn->transaction_id = Transaction::setTransactionId();
        $purchaseReturn->purchase_id = $request->purchaseId;
        $purchaseReturn->invoice_no = $request->invoiceNo;
        $purchaseReturn->vendor_id = $request->vendorId;
        $purchaseReturn->amount = $request->amount;
        // $purchaseReturn->balance_amount = $request->balance;
        $purchaseReturn->date = $request->date;
           $purchaseReturn->narration = $request->narration;
        $purchaseReturn->save();

        //updateAccounts
        $purchase = PurchaseEntry::where('transaction_id',$request->purchaseId)->first();

        $purchaseInventory = PurchaseInventoryOrder::where('transaction_id',$request->purchaseId)
        ->first();

        $payableAccount = SubAccounts::where('account_code',8080)->first();

        //update
        $transactionDetails = TransactionDetails::where('bill_no',$payableAccount->bill_no)
        ->where('unique_id',null)
        ->update(['debit_account'=>$payableAccount->transaction_id]);


        if($purchase==null)
        {
            $transactionTable = TransactionDetails::where('unique_id',$purchaseInventory->bill_no)->delete();

            $purchase = PurchaseInventoryOrder::where('transaction_id',$request->purchaseId)->delete();
            $purchase = PurchaseInventoryProducts::where('order_id',$request->purchaseId)->delete();

        }else{
            $transactionTable = TransactionDetails::where('unique_id',$purchase->bill_no)->delete();
            $purchase = PurchaseEntry::where('transaction_id',$request->purchaseId)->delete();
        }
       
        Alert::success('Success','Purchase Returned Successfully');
        return redirect('purchaseReturn');
    }

    public function purchaseSetup()
    {
        $name = Auth::user()->user_name;

        $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->get();

        $count = PurchaseSetup::where('id',1)->value('account_id');

        return view('purchase.purchaseSetup',['name'=>$name,'accounts'=>$accounts,'count'=>$count]);
    }

    public function storePurchaseSetup(Request $request)
    {
        $update = PurchaseSetup::where('id',$request->type)
        ->update(['account_id'=>$request->account]);

        return redirect()->back();
    }

    public function viewDetails(Request $request)
    {
        $name = Auth::user()->user_name;

        $purchaseCheck = PurchaseEntry::where('transaction_id',$request->id)->count();

        if($purchaseCheck!=0)
        {
            $purchase = PurchaseEntry::leftjoin('vendors','vendors.transaction_id','purchase_entries.vendor_id')
            ->select('vendors.name as vendorName','vendors.address as vendorAddress','vendors.country',
            'vendors.phone','vendors.email_id','purchase_entries.*')
            ->where('purchase_entries.transaction_id',$request->id)
            ->first();

            $products = null;

            $purchase->total_amount = $purchase->amount;

            $purchase->type = 'Normal';

        }
        else
        {
            $purchase = PurchaseInventoryOrder::leftjoin('vendors','vendors.transaction_id','purchase_inventory_orders.vendor_id')
            ->select('vendors.name as vendorName','vendors.address as vendorAddress','vendors.country',
            'vendors.phone','vendors.email_id','purchase_inventory_orders.*','purchase_inventory_orders.total_amount as amount',
            'purchase_inventory_orders.transaction_id as orderId')
            ->where('purchase_inventory_orders.transaction_id',$request->id)
            ->first(); 

            $products = PurchaseInventoryProducts::leftjoin('products','products.transaction_id','purchase_inventory_products.product_id')
            ->leftjoin('product_categories','product_categories.transaction_id','products.product_category_code')
            ->where('purchase_inventory_products.order_id',$purchase->orderId)
            ->select(DB::raw("CONCAT(products.product_name,'(',product_categories.category_name,')') AS label"),
                'purchase_inventory_products.*')
            ->get();   

            $purchase->type = 'Inventory';
        }

        return view('purchase.purchaseDetails',['name'=>$name,'purchase'=>$purchase,'products'=>$products]);
    }

    public function editPurchase(Request $request)
    {
       $name = Auth::user()->user_name;
       $purchase = null;
       $check = PurchaseEntry::where('transaction_id',$request->id)->count();

       if($check!=0)
       {
            $purchase = PurchaseEntry::where('transaction_id',$request->id)->first();

            $purchase->date = date('Y-m-d', strtotime($purchase->due_date));

            $vendor = Vendor::where('status',0)->select('name as label','transaction_id as value')->get();
        
            $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
            ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
            ->where('degree',AccountType::Normal)
            ->get();

            return view('purchase.purchaseEdit',['name'=>$name,'purchase'=>$purchase,'vendor'=>$vendor,'accounts'=>$accounts]);
       }else{
        
       }
        
    }

    public function updatePurchaseEntry(Request $request)
    {
        $vendorAccount = SubAccounts::where('account_code',$request->vendorId)
        ->select('transaction_id as accountNumber')->first();

        $amountTotal = $request->amount;
        // calcualte VAT
        $tax = (5 / 100) * $amountTotal;

        if($amountTotal<5)
        {
            $tax=0;
        }

        $purchase = PurchaseEntry::find($request->purchaseId);
        $purchase->description = $request->description;
        $purchase->vendor_id = $request->vendorId;
        $purchase->vendor_account_no = $vendorAccount->accountNumber;
        $purchase->debit_account_no = $request->accountId;
        $purchase->net_amount = $amountTotal - $tax;
        $purchase->tax = $tax;
        $purchase->amount = $amountTotal;
        $purchase->invoice_no = $request->invoiceNo;
        $purchase->due_date = date('d-m-Y', strtotime($request->due_date));
        $purchase->description = $request->description;
        $purchase->save();

        return redirect()->back();
    }

    public function deletePurchaseEntry(Request $request)
    {
       $purchase = PurchaseEntry::where('transaction_id',$request->userId)->first();

        if($purchase!=null)
        {   
            $transactionTable = TransactionDetails::where('unique_id',$purchase->bill_no)
            ->delete();
        }else{
            $inventory = PurchaseInventoryOrder::where('transaction_id',$request->userId)->first();

            $transaction = TransactionDetails::where('unique_id',$inventory->bill_no)
            ->delete();

            $products = PurchaseInventoryProducts::where('order_id',$inventory->transaction_id)
            ->delete();
        }

        $purchase = PurchaseEntry::where('transaction_id',$request->userId)->delete();
        $inventory = PurchaseInventoryOrder::where('transaction_id',$request->userId)->delete();

        Alert::success('Success','Purchase Entry Deleted Successfully');
        return redirect()->back();
    }

    public function printPurchaseHistory(Request $request)
    {
        $fromDate = date('Y-m-d', strtotime($request->from)) . ' 00:00:00';
        $toDate = date('Y-m-d', strtotime($request->to)) . ' 23:59:59';

        $purchase = PurchaseEntry::leftjoin('vendors','vendors.transaction_id','purchase_entries.vendor_id')
        ->select('vendors.name as vendorName','purchase_entries.*')
        ->whereBetween('purchase_entries.created_at', [$fromDate, $toDate])
        ->get();

        $inventory = PurchaseInventoryOrder::leftjoin('vendors','vendors.transaction_id','purchase_inventory_orders.vendor_id')
        ->select('vendors.name as vendorName','purchase_inventory_orders.*','purchase_inventory_orders.total_amount as amount')
        ->whereBetween('purchase_inventory_orders.created_at', [$fromDate, $toDate])
        ->get();

        $array = [];
        $totalPurchase = 0;
        $totalInventory = 0;
        
        foreach($purchase as $val)
        { 
            $val->type = 'Normal';

            array_push($array,$val);
            
            $totalPurchase += $val->amount;
        }
        
        foreach($inventory as $val)
        {
            $val->type = 'Inventory';
        
            array_push($array,$val);

            $totalInventory += $val->amount;
        }

        $total = $totalPurchase + $totalInventory;

        $today = Carbon::now()->format('d-F-Y');

        $pdf = PDF::loadView('pdf.purchaseHistory',['today'=>$today,'history'=>$array,'total'=>$total]);
        //  download PDF file with download method
        return $pdf->download('PurchaseHistory.pdf');
    }
}
