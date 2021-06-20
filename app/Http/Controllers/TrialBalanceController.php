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

class TrialBalanceController extends Controller
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

    public function trialBalance()
    {
        $name = Auth::user()->user_name;
        return view('trialBalance.trialBalance',['name'=>$name]);
    }

    public function trialBalanceResult(Request $request)
    {
        $this->validate(request(), [
            'date' => 'required',
        ]);
        
        $name = Auth::user()->user_name;
        $date = Carbon::parse($request->date);
        $thisMonthFirstDay = $date->firstOfMonth()->format('d-m-Y');  

        $firstDayYear = $date->startOfYear()->format('d-m-Y');

        $fromDateYear = date('Y-m-d', strtotime($firstDayYear)) . ' 00:00:00';

        $fromDate = date('Y-m-d', strtotime($thisMonthFirstDay)) . ' 00:00:00';
        $toDate = date('Y-m-d', strtotime($request->date)) . ' 23:59:59';

        $sumCredit1 = 0;
        $sumDebit1 = 0;
        $sumCredit2 = 0;
        $sumDebit2 = 0;
        $sumCreditYear1 = 0;
        $sumDebitYear1 = 0;
        $sumCreditYear2 = 0;
        $sumDebitYear2 = 0;

        //expense&income
        $accounts1 = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS accountName"),'sub_accounts.transaction_id as accountId');
        
        $accounts1 = $accounts1->where(function ($query) {
            $query->where('main_accounts.account_name','Expenditure');
            $query->orWhere('main_accounts.account_name','Income');
        });  
        $accounts1 = $accounts1->where(function ($query) {
            $query->where('degree',AccountType::Normal);
            $query->orWhere('degree',AccountType::PayAndReceive);
        })->get();

        foreach($accounts1 as $value)
        {
            $creditSum = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('transaction_details.amount');
    
            $debitSum = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('transaction_details.amount');   

            if($creditSum>$debitSum)
            {
                $credit = $creditSum-$debitSum;

                $value->credit = $credit;
                $value->debit = 0;
            }elseif($debitSum>$creditSum)
            {
                $debit = $debitSum-$creditSum;

                $value->credit = 0;
                $value->debit = $debit;
            }else{
                $value->credit = 0;
                $value->debit = 0;
            }
            
            $sumCredit1 += $value->credit;
            $sumDebit1 += $value->debit;

            //yearwise result
            $creditSumYear = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('date',[$fromDateYear, $toDate])
            ->sum('transaction_details.amount');
    
            $debitSumYear = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('date',[$fromDateYear, $toDate])
            ->sum('transaction_details.amount');   

            if($creditSumYear>$debitSumYear)
            {
                $credit = $creditSumYear-$debitSumYear;

                $value->creditYear = $credit;
                $value->debitYear = 0;
            }elseif($debitSumYear>$creditSumYear)
            {
                $debit = $debitSumYear-$creditSumYear;

                $value->creditYear = 0;
                $value->debitYear = $debit;
            }else{
                $value->creditYear = 0;
                $value->debitYear = 0;
            }
            
            $sumCreditYear1 += $value->creditYear;
            $sumDebitYear1 += $value->debitYear;

        }

        //assets&liabity
        $accounts2 = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS accountName"),'sub_accounts.transaction_id as accountId');
              
        $accounts2 = $accounts2->where(function ($query) {
            $query->where('degree',AccountType::Normal);
            $query->orWhere('degree',AccountType::PayAndReceive);
        });

        $accounts2 = $accounts2->where(function ($query) {
            $query->where('main_accounts.account_name','Assets');
            $query->orWhere('main_accounts.account_name','Liability'); 
        }) ->get();


        foreach($accounts2 as $value)
        {
            $creditSum = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('transaction_details.amount');
    
            $debitSum = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('transaction_details.amount');   

            if($creditSum>$debitSum)
            {
                $credit = $creditSum-$debitSum;

                $value->credit = $credit;
                $value->debit = 0;
            }elseif($debitSum>$creditSum)
            {
                $debit = $debitSum-$creditSum;

                $value->credit = 0;
                $value->debit = $debit;
            }else{
                $value->credit = 0;
                $value->debit = 0;
            }   

            $sumCredit2 += $value->credit;
            $sumDebit2 += $value->debit;

            //Yearwise result
            $creditSumYear = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('date',[$fromDateYear, $toDate])
            ->sum('transaction_details.amount');
    
            $debitSumYear = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('date',[$fromDateYear, $toDate])
            ->sum('transaction_details.amount');   

            if($creditSumYear>$debitSumYear)
            {
                $credit = $creditSumYear-$debitSumYear;

                $value->creditYear = $credit;
                $value->debitYear = 0;
            }elseif($debitSumYear>$creditSumYear)
            {
                $debit = $debitSumYear-$creditSumYear;

                $value->creditYear = 0;
                $value->debitYear = $debit;
            }else{
                $value->creditYear = 0;
                $value->debitYear = 0;
            }   

            $sumCreditYear2 += $value->creditYear;
            $sumDebitYear2 += $value->debitYear;
        }  
        
        
        return view('trialBalance.trialBalanceResult',['result1'=>$accounts1,'result2'=>$accounts2,'name'=>$name,
        'sumCredit1'=>$sumCredit1,'sumDebit1'=>$sumDebit1,'sumCredit2'=>$sumCredit2,'sumDebit2'=>$sumDebit2,'date'=>$request->date,
        'sumCreditYear1'=>$sumCreditYear1,'sumDebitYear1'=>$sumDebitYear1,'sumCreditYear2'=>$sumCreditYear2,
        'sumDebitYear2'=>$sumDebitYear2]);
    }

    public function exportToPdf(Request $request)
    {
        $this->validate(request(), [
            'date' => 'required',
        ]);
           
        $name = Auth::user()->user_name;
        $date = Carbon::parse($request->date);
        $thisMonthFirstDay = $date->firstOfMonth()->format('d-m-Y');  

        $firstDayYear = $date->startOfYear()->format('d-m-Y');

        $fromDateYear = date('Y-m-d', strtotime($firstDayYear)) . ' 00:00:00';

        $fromDate = date('Y-m-d', strtotime($thisMonthFirstDay)) . ' 00:00:00';
        $toDate = date('Y-m-d', strtotime($request->date)) . ' 23:59:59';

        $sumCredit1 = 0;
        $sumDebit1 = 0;
        $sumCredit2 = 0;
        $sumDebit2 = 0;
        $sumCreditYear1 = 0;
        $sumDebitYear1 = 0;
        $sumCreditYear2 = 0;
        $sumDebitYear2 = 0;

        //expense&income
        $accounts1 = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS accountName"),'sub_accounts.transaction_id as accountId');
        
        $accounts1 = $accounts1->where(function ($query) {
            $query->where('main_accounts.account_name','Expenditure');
            $query->orWhere('main_accounts.account_name','Income');
        });  
        $accounts1 = $accounts1->where(function ($query) {
            $query->where('degree',AccountType::Normal);
            $query->orWhere('degree',AccountType::PayAndReceive);
        })->get();

        foreach($accounts1 as $value)
        {
            $creditSum = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('transaction_details.amount');
    
            $debitSum = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('transaction_details.amount');   

            if($creditSum>$debitSum)
            {
                $credit = $creditSum-$debitSum;

                $value->credit = $credit;
                $value->debit = 0;
            }elseif($debitSum>$creditSum)
            {
                $debit = $debitSum-$creditSum;

                $value->credit = 0;
                $value->debit = $debit;
            }else{
                $value->credit = 0;
                $value->debit = 0;
            }
            
            $sumCredit1 += $value->credit;
            $sumDebit1 += $value->debit;

            //yearwise result
            $creditSumYear = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('date',[$fromDateYear, $toDate])
            ->sum('transaction_details.amount');
    
            $debitSumYear = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('date',[$fromDateYear, $toDate])
            ->sum('transaction_details.amount');   

            if($creditSumYear>$debitSumYear)
            {
                $credit = $creditSumYear-$debitSumYear;

                $value->creditYear = $credit;
                $value->debitYear = 0;
            }elseif($debitSumYear>$creditSumYear)
            {
                $debit = $debitSumYear-$creditSumYear;

                $value->creditYear = 0;
                $value->debitYear = $debit;
            }else{
                $value->creditYear = 0;
                $value->debitYear = 0;
            }
            
            $sumCreditYear1 += $value->creditYear;
            $sumDebitYear1 += $value->debitYear;

        }

        //assets&liabity
        $accounts2 = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS accountName"),'sub_accounts.transaction_id as accountId');
              
        $accounts2 = $accounts2->where(function ($query) {
            $query->where('degree',AccountType::Normal);
            $query->orWhere('degree',AccountType::PayAndReceive);
        });

        $accounts2 = $accounts2->where(function ($query) {
            $query->where('main_accounts.account_name','Assets');
            $query->orWhere('main_accounts.account_name','Liability'); 
        }) ->get();

        foreach($accounts2 as $value)
        {
            $creditSum = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('transaction_details.amount');
    
            $debitSum = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('transaction_details.amount');   

            if($creditSum>$debitSum)
            {
                $credit = $creditSum-$debitSum;

                $value->credit = $credit;
                $value->debit = 0;
            }elseif($debitSum>$creditSum)
            {
                $debit = $debitSum-$creditSum;

                $value->credit = 0;
                $value->debit = $debit;
            }else{
                $value->credit = 0;
                $value->debit = 0;
            }   

            $sumCredit2 += $value->credit;
            $sumDebit2 += $value->debit;

            //Yearwise result
            $creditSumYear = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('date',[$fromDateYear, $toDate])
            ->sum('transaction_details.amount');
    
            $debitSumYear = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('date',[$fromDateYear, $toDate])
            ->sum('transaction_details.amount');   

            if($creditSumYear>$debitSumYear)
            {
                $credit = $creditSumYear-$debitSumYear;

                $value->creditYear = $credit;
                $value->debitYear = 0;
            }elseif($debitSumYear>$creditSumYear)
            {
                $debit = $debitSumYear-$creditSumYear;

                $value->creditYear = 0;
                $value->debitYear = $debit;
            }else{
                $value->creditYear = 0;
                $value->debitYear = 0;
            }   

            $sumCreditYear2 += $value->creditYear;
            $sumDebitYear2 += $value->debitYear;
        }

        $today = Carbon::now()->format('d-F-Y');

        $pdf = PDF::loadView('pdf.trialBalancePdf',['today'=>$today,'result1'=>$accounts1,'sumCredit1'=>$sumCredit1,'sumDebit1'=>$sumDebit1,
        'result2'=>$accounts2,'sumCredit2'=>$sumCredit2,'sumDebit2'=>$sumDebit2,'sumCreditYear1'=>$sumCreditYear1,
        'sumCreditYear2'=>$sumCreditYear2,'sumDebitYear1'=>$sumDebitYear1,'sumDebitYear2'=>$sumDebitYear2]);

        //  download PDF file with download method
        return $pdf->download('TrialBalance.pdf');
    } 
}
