<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SubAccounts;
use App\Common\AccountType;
use App\Models\TransactionDetails;
use App\Models\Vendor;
use App\Models\PurchaseEntry;
use App\Models\PurchaseInventoryOrder;
use App\Models\PurchasePayment;

class GeneralLedgerController extends Controller
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

    public function viewGeneralLedger()
    {
        $accounts = $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->get();

         $name = Auth::user()->user_name;
        return view('ledger.generalLedger',['name'=>$name,'accounts'=>$accounts]);
    }

    public function generalLedgerResult(Request $request)
    {
        $this->validate(request(), [
            'fromDate' => 'required',
            'toDate' => 'required',
            'accountId' => 'required',
        ]);

        $name = Auth::user()->user_name;
        $from = $request->fromDate;
        $to = $request->toDate;
        $fromDate = date('Y-m-d', strtotime($from)) . ' 00:00:00';
        $toDate = date('Y-m-d', strtotime($to)) . ' 23:59:59';

        $array = [];

        $transactionCredit = TransactionDetails::where('credit_account',$request->accountId)
        ->whereBetween('date',[$fromDate, $toDate])
        ->select(DB::raw('DATE_FORMAT(transaction_details.created_at, "%d-%m-%Y") as date'),'transaction_details.amount as credit','transaction_details.transaction_id')
        ->get();

        $creditSum = TransactionDetails::where('credit_account',$request->accountId)
        ->whereBetween('date',[$fromDate, $toDate])
        ->sum('transaction_details.amount');

        foreach($transactionCredit as $value)
        {
           $purchase = PurchaseEntry::where('transaction_details_id',$value->transaction_id)->count();

           $purchseInventory = PurchaseInventoryOrder::where('transaction_details_id',$value->transaction_id)->count();

           $payment = PurchasePayment::where('transaction_details_id',$value->transaction_id)->count();

           if($purchase!=null)
           {
            $purchase = PurchaseEntry::where('transaction_details_id',$value->transaction_id)->first();

            $value->billNo = $purchase->bill_no;
            $value->description = $purchase->description;
           }

           if($purchseInventory!=null)
           {
            $purchseInventory = PurchaseInventoryOrder::where('transaction_details_id',$value->transaction_id)->first();

            $value->billNo = $purchseInventory->bill_no;
            $value->description = $purchseInventory->description;
           }

           if($payment!=null)
           {
            $payment = PurchasePayment::where('transaction_details_id',$value->transaction_id)->first();

            $value->billNo = $payment->billNo;
            $value->description = 'Payment';
           }

            $value->debit = 0;

            array_push($array,$value);
        }

        $transactionDebit = TransactionDetails::where('debit_account',$request->accountId)
        ->whereBetween('date',[$fromDate, $toDate])
        ->select(DB::raw('DATE_FORMAT(transaction_details.created_at, "%d-%m-%Y") as date'),'transaction_details.amount as debit','transaction_details.transaction_id')
        ->get();

        $debitSum = TransactionDetails::where('debit_account',$request->accountId)
        ->whereBetween('date',[$fromDate, $toDate])
        ->sum('transaction_details.amount');
        
        foreach($transactionDebit as $value)
        {
            $purchase = PurchaseEntry::where('transaction_details_id',$value->transaction_id)->count();

           $purchseInventory = PurchaseInventoryOrder::where('transaction_details_id',$value->transaction_id)->count();

           $payment = PurchasePayment::where('transaction_details_id',$value->transaction_id)->count();

           if($purchase!=null)
           {
            $purchase = PurchaseEntry::where('transaction_details_id',$value->transaction_id)->first();

            $value->billNo = $purchase->bill_no;
            $value->description = $purchase->description;
           }

           if($purchseInventory!=null)
           {
            $purchseInventory = PurchaseInventoryOrder::where('transaction_details_id',$value->transaction_id)->first();

            $value->billNo = $purchseInventory->bill_no;
            $value->description = $purchseInventory->description;
           }

           if($payment!=null)
           {
            $payment = PurchasePayment::where('transaction_details_id',$value->transaction_id)->first();

            $value->billNo = $payment->billNo;
            $value->description = 'Payment';
           }

            $value->credit = 0;

            array_push($array,$value);
        }

        return view('ledger.generalLedgerResult',['generalLedger'=>$array,'name'=>$name,'creditSum'=>$creditSum,'debitSum'=>$debitSum]);
    }

    public function viewSubsidiaryLedger()
    {
        $vendors = Vendor::where('status',0)->get();

        $name = Auth::user()->user_name;
        return view('ledger.searchSubsidaryLedger',['name'=>$name,'vendors'=>$vendors]);
    }

    public function subsidaryLedgerResult(Request $request)
    {
        $this->validate(request(), [
            'fromDate' => 'required',
            'toDate' => 'required',
            'vendorId' => 'required',
        ]);
        
        $name = Auth::user()->user_name;
        $from = $request->fromDate;
        $to = $request->toDate;
        $fromDate = date('Y-m-d', strtotime($from)) . ' 00:00:00';
        $toDate = date('Y-m-d', strtotime($to)) . ' 23:59:59';

        $array = [];

        $transactionDebit = TransactionDetails::leftjoin('sub_accounts','sub_accounts.transaction_id','transaction_details.debit_account')
        ->leftjoin('vendors','vendors.transaction_id','sub_accounts.account_code')
        ->where('vendors.transaction_id',$request->vendorId)
        ->whereBetween('transaction_details.date',[$fromDate, $toDate])
        ->select(DB::raw('DATE_FORMAT(transaction_details.created_at, "%d-%m-%Y") as date'),'transaction_details.amount as debit',
        'transaction_details.transaction_id','transaction_details.narration as description','transaction_details.bill_no as billNo')
        ->get();
       
        $debitSum = TransactionDetails::leftjoin('sub_accounts','sub_accounts.transaction_id','transaction_details.debit_account')
        ->leftjoin('vendors','vendors.transaction_id','sub_accounts.account_code')
        ->where('vendors.transaction_id',$request->vendorId)
        ->whereBetween('transaction_details.date',[$fromDate, $toDate])
        ->sum('transaction_details.amount');
       
        foreach($transactionDebit as $value)
        {
           $purchase = PurchaseEntry::where('transaction_details_id',$value->transaction_id)->count();

           $purchseInventory = PurchaseInventoryOrder::where('transaction_details_id',$value->transaction_id)->count();

           $payment = PurchasePayment::where('transaction_details_id',$value->transaction_id)->count();

           $value->credit = 0;

           array_push($array,$value);
        }

        $transactionCredit = TransactionDetails::leftjoin('sub_accounts','sub_accounts.transaction_id','transaction_details.credit_account')
        ->leftjoin('vendors','vendors.transaction_id','sub_accounts.account_code')
        ->where('vendors.transaction_id',$request->vendorId)
        ->whereBetween('transaction_details.date',[$fromDate, $toDate])
        ->select(DB::raw('DATE_FORMAT(transaction_details.created_at, "%d-%m-%Y") as date'),'transaction_details.amount as credit',
        'transaction_details.transaction_id','transaction_details.narration as description','transaction_details.bill_no as billNo')
        ->get();

        $creditSum = TransactionDetails::leftjoin('sub_accounts','sub_accounts.transaction_id','transaction_details.credit_account')
        ->leftjoin('vendors','vendors.transaction_id','sub_accounts.account_code')
        ->where('vendors.transaction_id',$request->vendorId)
        ->whereBetween('transaction_details.date',[$fromDate, $toDate])
        ->sum('transaction_details.amount');

        foreach($transactionCredit as $value)
        {
           $purchase = PurchaseEntry::where('transaction_details_id',$value->transaction_id)->count();

           $purchseInventory = PurchaseInventoryOrder::where('transaction_details_id',$value->transaction_id)->count();

           $payment = PurchasePayment::where('transaction_details_id',$value->transaction_id)->count();
           
           $value->debit = 0;

            array_push($array,$value);
        }
        return view('ledger.subsidaryLedgerResult',['name'=>$name,'ledger'=>$array,'debitSum'=>$debitSum,'creditSum'=>$creditSum]);
    }
}
