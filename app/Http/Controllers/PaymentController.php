<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\PurchaseEntry;
use App\Models\SetupAccounts;
use App\Common\PaymentMethodSelected;
use App\Common\PaymentStatus;
use App\Models\Vendor;
use App\Models\SubAccounts;
use App\Models\TransactionDetails;  
use App\TransactionId\Transaction;
use App\Models\PurchasePayment;
use App\Models\PurchaseInventoryOrder;
use App\Common\TransactionType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use App\Models\PurchaseInventoryProducts;

class PaymentController extends Controller
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

    public function purchasePayment()
    {
        $name = Auth::user()->user_name;

        $paymentMethod = SetupAccounts::where('selected_status',PaymentMethodSelected::Selected)
        ->select('account_type as label','account_id as value')
        ->get();
        
        $purchase = PurchaseEntry::leftjoin('vendors','vendors.transaction_id','purchase_entries.vendor_id')
        ->select('vendors.name as vendorName','purchase_entries.*')->get();

        $inventory = PurchaseInventoryOrder::leftjoin('vendors','vendors.transaction_id','purchase_inventory_orders.vendor_id')
        ->select('vendors.name as vendorName','purchase_inventory_orders.*','purchase_inventory_orders.total_amount as amount')->get();

        $array = [];
        foreach($purchase as $val)
        {
            $payment = PurchasePayment::where('billNo',$val->bill_no)->sum('amount');

            $pending = $val->amount;
 
            $duoAmount = $pending-$payment;

            $val->pending = $duoAmount;
            
            $val->type = 'Normal';

            array_push($array,$val);    
        }
        
        foreach($inventory as $val)
        {
            $check = PurchaseInventoryProducts::where('order_id',$val->transaction_id)->count();

            if($check==0)
            {
                PurchaseInventoryOrder::where('transaction_id',$val->transaction_id)->delete();
                TransactionDetails::where('transaction_id',$val->transaction_details_id)->delete();
            }

            $payment = PurchasePayment::where('billNo',$val->bill_no)->sum('amount');

            $pending = $val->amount;
 
            $duoAmount = $pending-$payment;

            $val->pending = $duoAmount;

            $val->type = 'Inventory';
        
            array_push($array,$val);
        }

    //     return $array;
    
    //     $array1 = collect($array)->sortBy('id')->toArray();

    //    return $array2 = array_values($array1);

        return view('payment.purchasePayment',['name'=>$name,'purchase'=>$array,'paymentMethod'=>$paymentMethod]);
    }

    public function storePurchasePayment(Request $request)
    {
        $this->validate(request(), [
            'paymentMethod' => 'required',
            'paymentDate' => 'required',
            'narration' => 'required',
        ]);

        $vendorId = Vendor::leftjoin('purchase_entries','purchase_entries.vendor_id','vendors.transaction_id')
        ->where('purchase_entries.bill_no',$request->billNumber)
        ->value('vendors.transaction_id');

        if($vendorId==null)
        {
            $vendorIdInventory = Vendor::leftjoin('purchase_inventory_orders','purchase_inventory_orders.vendor_id','vendors.transaction_id')
            ->where('purchase_inventory_orders.bill_no',$request->billNumber)
            ->value('vendors.transaction_id');

            $vendorAccountId = SubAccounts::where('account_code',$vendorIdInventory)
            ->value('transaction_id');
    
        }else{
            $vendorAccountId = SubAccounts::where('account_code',$vendorId)
            ->value('transaction_id');
    
        }        
        $method = SetupAccounts::where('account_id',$request->paymentMethod)
        ->value('account_type');

        $payableAccount = SubAccounts::where('account_code',9090)->first();

        //create transaction
        $transaction = new TransactionDetails();
        $transaction->transaction_id = Transaction::setTransactionId();
        $transaction->type = TransactionType::payment;
        $transaction->credit_account = $request->paymentMethod;
        $transaction->debit_account = $payableAccount->transaction_id;
        $transaction->amount = $request->amount;
        $transaction->bill_no = $request->billNumber;
        $transaction->narration = $request->narration;
        $transaction->date = $request->paymentDate;
        $transaction->save();
        
        //create purchase payment
        $purchasePayment = new PurchasePayment();
        $purchasePayment->transaction_id = Transaction::setTransactionId();
        if($vendorId!=null)
        {
            $purchasePayment->vendorId = $vendorId;
        }else{
            $purchasePayment->vendorId = $vendorIdInventory;
        }
        $purchasePayment->billNo = $request->billNumber;
        $purchasePayment->amount = $request->amount;
        $purchasePayment->payment_method = $method;
        $purchasePayment->payment_account_id = $request->paymentMethod; 
        $purchasePayment->transaction_details_id = $transaction->transaction_id;
        $purchasePayment->save();

        $updatePayment = PurchaseEntry::where('bill_no',$request->billNumber)
        ->update(['payment_status'=>PaymentStatus::paid]);

        return redirect('paymentPurchase')->with('message', 'Paid Successfully!');        

    }
    
    public function viewPaymentHistory()
    {
        $paymentHistory = TransactionDetails::leftjoin('purchase_payments','purchase_payments.transaction_details_id','transaction_details.transaction_id')
        ->leftjoin('sub_accounts as debitAccount','debitAccount.transaction_id','transaction_details.debit_account')
        ->leftjoin('sub_accounts as creditAccount','creditAccount.transaction_id','transaction_details.credit_account')
        ->leftjoin('vendors','vendors.transaction_id','purchase_payments.vendorId')
        ->select('vendors.name as debitAccount','creditAccount.account_name as creditAccount',
        'transaction_details.amount',DB::raw('DATE_FORMAT(transaction_details.created_at, "%d-%m-%Y") as date'),
        'purchase_payments.billNo')
        ->where('transaction_details.type',TransactionType::payment)
        ->get();
        
        $name = Auth::user()->user_name;
        return view('payment.paymentHistory',['name'=>$name,'history'=>$paymentHistory]);
    }

    public function paymentHistorySearch(Request $request)
    {  
        if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = TransactionDetails::leftjoin('purchase_payments','purchase_payments.transaction_details_id','transaction_details.transaction_id')
       ->leftjoin('sub_accounts as debitAccount','debitAccount.transaction_id','transaction_details.debit_account')
       ->leftjoin('sub_accounts as creditAccount','creditAccount.transaction_id','transaction_details.credit_account')
       ->leftjoin('vendors','vendors.transaction_id','purchase_payments.vendorId')
       ->select('vendors.name as debitAccount','creditAccount.account_name as creditAccount',
       'transaction_details.amount',DB::raw('DATE_FORMAT(transaction_details.created_at, "%d-%m-%Y") as date'),
       'purchase_payments.billNo')
       ->where('transaction_details.type',TransactionType::payment);

       $data = $data->where(function ($q) use ($query) {
        $q->where('creditAccount.account_name', 'like', '%'.$query.'%');
        $q->orWhere('debitAccount.account_name', 'like', '%'.$query.'%');
        $q->orWhere('purchase_payments.billNo', 'like', '%'.$query.'%');
        })
        ->get();
 
      }
      else
      {
        $data = TransactionDetails::leftjoin('purchase_payments','purchase_payments.transaction_details_id','transaction_details.transaction_id')
        ->leftjoin('sub_accounts as debitAccount','debitAccount.transaction_id','transaction_details.debit_account')
        ->leftjoin('sub_accounts as creditAccount','creditAccount.transaction_id','transaction_details.credit_account')
        ->leftjoin('vendors','vendors.transaction_id','purchase_payments.vendorId')
        ->select('vendors.name as debitAccount','creditAccount.account_name as creditAccount',
        'transaction_details.amount',DB::raw('DATE_FORMAT(transaction_details.created_at, "%d-%m-%Y") as date'),
        'purchase_payments.billNo','transaction_details.transaction_id as paymentId')
        ->where('transaction_details.type',TransactionType::payment)
        ->get();

    }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
           $i=0;$i++;
        $output .= '
        <tr>
         <td>'.$i.'</td>
         <td>'.$row->creditAccount.'</td>
         <td>'.$row->debitAccount.'</td>
         <td>'.$row->amount.'</td>
         <td>'.$row->billNo.'</td>
         <td>'.$row->date.'</td>
         <td><a href="/printPaymentBill/'.$row->paymentId.'"><button type="submit" class="btn bg-gradient-primary">
         Print</button></a></td>
        </tr>
        ';
       }
      }
      else
      {
          
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }

    public function printPaymentBill($id)
    {
       $billData = TransactionDetails::leftjoin('purchase_payments','purchase_payments.transaction_details_id','transaction_details.transaction_id')       
       ->leftjoin('vendors','vendors.transaction_id','purchase_payments.vendorId')
       ->select('vendors.name as vendorName','vendors.address as vendorAddress','vendors.country','vendors.state',
       'vendors.phone','vendors.email_id',
       'transaction_details.amount',DB::raw('DATE_FORMAT(transaction_details.created_at, "%d-%m-%Y") as date'),
       'purchase_payments.billNo')
       ->where('transaction_details.type',TransactionType::payment)
       ->first();

        $product=null;
        $purchaseInventory = PurchaseInventoryOrder::where('purchase_inventory_orders.bill_no',$billData->billNo)
        ->first();

        if(isset($purchaseInventory))
        {
            $product = PurchaseInventoryProducts::leftjoin('products','products.transaction_id','purchase_inventory_products.product_id')
            ->where('purchase_inventory_products.order_id',$purchase->orderId)
            ->select('products.product_name','products.product_code','purchase_inventory_products.quantity','products.price')
            ->get();
        }

        $today = Carbon::now()->format('d-F-Y');

        $pdf = PDF::loadView('pdf.paymentBill',['today'=>$today,'billData'=>$billData]);

        //  download PDF file with download method
        return $pdf->download('paymentBill.pdf');
    }
}
