<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\SubAccounts;
use Illuminate\Support\Facades\DB;
use App\Common\AccountType;
use App\Models\TransactionDetails;
use Carbon\Carbon;
use PDF;
use App\Models\RestSale;
use App\Models\PurchaseEntry;
use App\Models\PurchaseInventoryOrder;

class BalanceSheetController extends Controller
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

    public function balanceSheet()
    {
        $name = Auth::user()->user_name;

        return view('balanceSheet.balanceSheet',['name'=>$name]);
    }

    public function viewBalanceSheet(Request $request)
    {
       if(!isset($request))
       {
           return redirect()->back();
       }

        $name = Auth::user()->user_name;

        if($request->month)
        {
            $date = Carbon::parse($request->month);

            $showDate = $date->format('d-F-Y');
            $showMonth = $date->format('F');
            $showYear = $date->format('Y');
            
            $thisMonthFirstDay = $date->firstOfMonth()->format('d-m-Y');  
            $thisMonthLastDay = $date->endOfMonth()->format('d-m-Y');  

            $firstDayYear = $date->startOfYear()->format('d-m-Y');
            $fromDateYear = date('Y-m-d', strtotime($firstDayYear)) . ' 00:00:00';
            $fromDate = date('Y-m-d', strtotime($thisMonthFirstDay)) . ' 00:00:00';
            $toDate = date('Y-m-d', strtotime($thisMonthLastDay)) . ' 23:59:59';

            $endShowDate = Carbon::parse($thisMonthLastDay);

            $showEndDate = $endShowDate->format('d-F-Y');

            $dateType = 'month';

        }else if($request->date){

            $date = Carbon::parse($request->date);
            $showMonth = $date->format('F');
            $showYear = $date->format('Y');

            $thisMonthFirstDay = $date->firstOfMonth()->format('d-m-Y');  
            $firstDayYear = $date->startOfYear()->format('d-m-Y');
            $fromDateYear = date('Y-m-d', strtotime($firstDayYear)) . ' 00:00:00';
            $fromDate = date('Y-m-d', strtotime($thisMonthFirstDay)) . ' 00:00:00';
            $toDate = date('Y-m-d', strtotime($request->date)) . ' 23:59:59';

            $firstDay = Carbon::parse($thisMonthFirstDay);

            $showDate = $firstDay->format('d-F-Y');

            $endShowDate = Carbon::parse($toDate);

            $showEndDate = $endShowDate->format('d-F-Y');

            $dateType = 'date';
        }
        else{

            $year = Carbon::parse($request->year)->startOfYear()->format('d-m-Y');

            $date = Carbon::parse($year);

            $showDate = $date->format('d-F-Y');
            $showMonth = $date->format('F');
            $showYear = $date->format('Y');

            $thisMonthFirstDay = $date->firstOfMonth()->format('d-m-Y');  
            $firstDayYear = $date->startOfYear()->format('d-m-Y');
            $endDayYear = $date->endOfYear()->format('d-m-Y');

            $fromDateYear = date('Y-m-d', strtotime($firstDayYear)) . ' 00:00:00';
            $fromDate = date('Y-m-d', strtotime($thisMonthFirstDay)) . ' 00:00:00';
            $toDate = date('Y-m-d', strtotime($endDayYear)) . ' 23:59:59';

            $endShowDate = Carbon::parse($endDayYear);

            $showEndDate = $endShowDate->format('d-F-Y');

            $dateType = 'year';
        }
        $totalAsset = 0;
        $totalLiability = 0;
        $array = [];

        //assets&liabity
        $assets = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->where('main_accounts.account_name','Assets')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS accountName"),'sub_accounts.transaction_id as accountId',
            'main_accounts.account_name');
              
        $assets = $assets->where(function ($query) {
            $query->where('degree',AccountType::Normal);
            $query->orWhere('degree',AccountType::PayAndReceive);
        })->get();

        $liabilities = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->where('main_accounts.account_name','Liability')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS accountName"),
        'sub_accounts.transaction_id as accountId',
            'main_accounts.account_name');

        $liabilities = $liabilities->where(function ($query) {
            $query->where('degree',AccountType::Normal);
            $query->orWhere('degree',AccountType::PayAndReceive);
        })->get();
        
        foreach($assets as $value)
        {
            // $credit = TransactionDetails::where('credit_account',$value->accountId)
            // ->whereBetween('created_at',[$fromDate, $toDate])
            // ->sum('amount');

            $debit = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('created_at',[$fromDate, $toDate])
            ->sum('amount');
        
            $value->actualAmount = $debit;

            $totalAsset += $value->actualAmount;

            if($value->actualAmount!=0)
            {
                array_push($array,$value);
            }
        }

        foreach($liabilities as $value)
        {
            $credit = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('created_at',[$fromDate, $toDate])
            ->sum('amount');

            // $debit = TransactionDetails::where('debit_account',$value->accountId)
            // ->whereBetween('created_at',[$fromDate, $toDate])
            // ->sum('amount');
        
            $value->actualAmount = $credit;

            $totalLiability += $value->actualAmount;

            if($value->actualAmount!=0)
            {
                array_push($array,$value);
            }
        }
        //calculate equity
        $product['accountName'] = 'Equity';
        $product['account_name'] = 'Equity';
        $product['actualAmount'] = $totalAsset-$totalLiability;

        //calculate retail earnings
        $totalSale = RestSale::whereBetween('created_at',[$fromDate, $toDate])
        ->where('payment_status',1)
        ->sum('total_amount');
        
        $purchase = PurchaseEntry::whereBetween('created_at',[$fromDate, $toDate])
        ->sum('amount');
        $purchaseInvent = PurchaseInventoryOrder::whereBetween('created_at',[$fromDate, $toDate])
        ->sum('total_amount');

        $totalPurchase = $purchase + $purchaseInvent;

        $total = $totalSale-$totalPurchase;

        if($total<0)
        {
            $total = 0;
        }

        $product2['accountName'] = 'Retail Earnings';
        $product2['account_name'] = 'Equity';
        $product2['actualAmount'] = $total;
       
        $totalLiability = $totalLiability+$product['actualAmount'];
        
        return view('balanceSheet.balanceSheetResult',['assets'=>$assets,'liabilities'=>$liabilities,
        'totalAsset'=>$totalAsset,'totalLiability'=>$totalLiability,'name'=>$name,'date'=>$showDate,
        'product'=>$product,'product2'=>$product2,
        'month'=>$showMonth,'year'=>$showYear,'endDate'=>$showEndDate,'array'=>$array,'dateType'=>$dateType]);
    }

    public function balanceSheetPdf(Request $request)
    {   
        if($request->type == 'month')
        {
            $date = Carbon::parse($request->date);

            $showDate = $date->format('d-F-Y');
            $showMonth = $date->format('F');
            $showYear = $date->format('Y');
            
            $thisMonthFirstDay = $date->firstOfMonth()->format('d-m-Y');  
            $thisMonthLastDay = $date->endOfMonth()->format('d-m-Y');  

            $firstDayYear = $date->startOfYear()->format('d-m-Y');
            $fromDateYear = date('Y-m-d', strtotime($firstDayYear)) . ' 00:00:00';
            $fromDate = date('Y-m-d', strtotime($thisMonthFirstDay)) . ' 00:00:00';
            $toDate = date('Y-m-d', strtotime($thisMonthLastDay)) . ' 23:59:59';

            $endShowDate = Carbon::parse($thisMonthLastDay);

            $showEndDate = $endShowDate->format('d-F-Y');

        }else if($request->type = 'date'){

            $date = Carbon::parse($request->date);
            $showMonth = $date->format('F');
            $showYear = $date->format('Y');

            $thisMonthFirstDay = $date->firstOfMonth()->format('d-m-Y');  
            $firstDayYear = $date->startOfYear()->format('d-m-Y');
            $fromDateYear = date('Y-m-d', strtotime($firstDayYear)) . ' 00:00:00';
            $fromDate = date('Y-m-d', strtotime($thisMonthFirstDay)) . ' 00:00:00';
            $toDate = date('Y-m-d', strtotime($request->date)) . ' 23:59:59';

            $firstDay = Carbon::parse($thisMonthFirstDay);

            $showDate = $firstDay->format('d-F-Y');

            $endShowDate = Carbon::parse($toDate);

            $showEndDate = $endShowDate->format('d-F-Y');
        }
        else{

            $year = Carbon::parse($request->date)->startOfYear()->format('d-m-Y');

            $date = Carbon::parse($year);

            $showDate = $date->format('d-F-Y');
            $showMonth = $date->format('F');
            $showYear = $date->format('Y');

            $thisMonthFirstDay = $date->firstOfMonth()->format('d-m-Y');  
            $firstDayYear = $date->startOfYear()->format('d-m-Y');
            $endDayYear = $date->endOfYear()->format('d-m-Y');

            $fromDateYear = date('Y-m-d', strtotime($firstDayYear)) . ' 00:00:00';
            $fromDate = date('Y-m-d', strtotime($thisMonthFirstDay)) . ' 00:00:00';
            $toDate = date('Y-m-d', strtotime($endDayYear)) . ' 23:59:59';

            $endShowDate = Carbon::parse($endDayYear);

            $showEndDate = $endShowDate->format('d-F-Y');
        }
        
        $totalAsset = 0;
        $totalLiability = 0;
        $array = [];

        //assets&liabity
        $assets = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->where('main_accounts.account_name','Assets')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS accountName"),'sub_accounts.transaction_id as accountId',
            'main_accounts.account_name');
              
        $assets = $assets->where(function ($query) {
            $query->where('degree',AccountType::Normal);
            $query->orWhere('degree',AccountType::PayAndReceive);
        })->get();

        $liabilities = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->where('main_accounts.account_name','Liability')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS accountName"),
        'sub_accounts.transaction_id as accountId',
            'main_accounts.account_name');
              
        $liabilities = $liabilities->where(function ($query) {
            $query->where('degree',AccountType::Normal);
            $query->orWhere('degree',AccountType::PayAndReceive);
        })->get();

        foreach($assets as $value)
        {
            $credit = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('created_at',[$fromDate, $toDate])
            ->sum('amount');

            $debit = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('created_at',[$fromDate, $toDate])
            ->sum('amount');
        
            $value->actualAmount = $debit - $credit;

            $totalAsset += $value->actualAmount;

            array_push($array,$value);
        }

        foreach($liabilities as $value)
        {
            $credit = TransactionDetails::where('credit_account',$value->account_id)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('amount');

            $debit = TransactionDetails::where('debit_account',$value->account_id)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('amount');
        
            $value->actualAmount = $debit - $credit;

            $totalLiability += $value->actualAmount;

            array_push($array,$value);
        }
        

        $today = Carbon::now()->format('d-F-Y');

        $pdf = PDF::loadView('pdf.balanceSheetPdf',['today'=>$today,'assets'=>$assets,'liabilities'=>$liabilities,
        'totalAsset'=>$totalAsset,'totalLiability'=>$totalLiability,'date'=>$showDate,
        'month'=>$showMonth,'year'=>$showYear,'endDate'=>$showEndDate]);


        //  download PDF file with download method
        return $pdf->download('balanceSheet.pdf');
        
    }

    public function balanceSheetShow()
    {
        $name = Auth::user()->user_name;

        // return view
    }
}