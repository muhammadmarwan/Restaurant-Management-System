<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\SubAccounts;
use Illuminate\Support\Facades\DB;
use App\Common\AccountType;
use App\Models\TransactionDetails;
use PDF;

class ProfitAndLossController extends Controller
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

    public function profitAndLoss()
    {
        $name = Auth::user()->user_name;
        return view('profitAndLoss.profitAndLoss',['name'=>$name]);
    }

    public function viewProfitAndLoss(Request $request)
    {
        $this->validate(request(), [
            'date' => 'required',
        ]);
        
        $name = Auth::user()->user_name;
        $date = Carbon::parse($request->date);
        $showDate = $date->format('d-F-Y');
        $showMonth = $date->format('F');
        $showYear = $date->format('Y');

        $thisMonthFirstDay = $date->firstOfMonth()->format('d-m-Y');  
        $firstDayYear = $date->startOfYear()->format('d-m-Y');
        $fromDateYear = date('Y-m-d', strtotime($firstDayYear)) . ' 00:00:00';
        $fromDate = date('Y-m-d', strtotime($thisMonthFirstDay)) . ' 00:00:00';
        $toDate = date('Y-m-d', strtotime($request->date)) . ' 23:59:59';

        $sumCreditIncome = 0;
        $sumCreditYearIncome = 0;
        $sumDebitExpense = 0;
        $sumDebitYearExpense = 0;
        
        //expense&income
        $profitAndLoss = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS accountName"),'sub_accounts.transaction_id as accountId',
        'main_accounts.account_name as type');
        
        $profitAndLoss = $profitAndLoss->where(function ($query) {
            $query->where('main_accounts.account_name','Expenditure');
            $query->orWhere('main_accounts.account_name','Income');
        });  
        $profitAndLoss = $profitAndLoss->where(function ($query) {
            $query->where('degree',AccountType::Normal);
            $query->orWhere('degree',AccountType::PayAndReceive);
        })->get();

        foreach($profitAndLoss as $value)
        {
            $creditSum = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('transaction_details.amount');
    
            $debitSum = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('transaction_details.amount');   

            if($value->type=='Income')
            {    
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

                $sumCreditIncome += $value->credit;

            }else{
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

                $sumDebitExpense += $value->debit;
            
            }
            
            //Yearwise result
            $creditSumYear = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('date',[$fromDateYear, $toDate])
            ->sum('transaction_details.amount');
    
            $debitSumYear = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('date',[$fromDateYear, $toDate])
                ->sum('transaction_details.amount');   

                if($value->type=='Income')
                {    
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

                    $sumCreditYearIncome += $value->creditYear;
    
                }else{
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
    
                    $sumDebitYearExpense += $value->debitYear;
                
                }
            }
            
            if($sumCreditIncome>=$sumDebitExpense)
            {
                $result = 'Profit';
                
                $resultAmount = $sumCreditIncome - $sumDebitExpense;
            }else{
                $result = 'Loss';
                
                $resultAmount = $sumDebitExpense - $sumCreditIncome;
            }
            
            if($sumCreditYearIncome>=$sumDebitYearExpense)
            {
                $resultYear = 'Profit';
                
                $resultAmountYear = $sumCreditYearIncome - $sumDebitYearExpense;
            }else{
                $resultYear = 'Loss';
                
                $resultAmountYear = $sumDebitYearExpense - $sumCreditYearIncome;
            }
        
        return view('profitAndLoss.profitAndLossResult',['profitAndLoss'=>$profitAndLoss,
        'sumCreditIncome'=>$sumCreditIncome,'sumDebitExpense'=>$sumDebitExpense,
        'sumCreditYearIncome'=>$sumCreditYearIncome,'sumDebitYearExpense'=>$sumDebitYearExpense,
        'name'=>$name,'date'=>$showDate,'month'=>$showMonth,'year'=>$showYear,'result'=>$result,
        'resultAmount'=>$resultAmount,'resultYear'=>$resultYear,'resultAmountYear'=>$resultAmountYear]);
    }

    public function printProfitAndLoss(Request $request)
    {
        $name = Auth::user()->user_name;
        $date = Carbon::parse($request->date);
        $showDate = $date->format('d-F-Y');
        $showMonth = $date->format('F');
        $showYear = $date->format('Y');

        $thisMonthFirstDay = $date->firstOfMonth()->format('d-m-Y');  
        $firstDayYear = $date->startOfYear()->format('d-m-Y');
        $fromDateYear = date('Y-m-d', strtotime($firstDayYear)) . ' 00:00:00';
        $fromDate = date('Y-m-d', strtotime($thisMonthFirstDay)) . ' 00:00:00';
        $toDate = date('Y-m-d', strtotime($request->date)) . ' 23:59:59';

        $sumCreditIncome = 0;
        $sumCreditYearIncome = 0;
        $sumDebitExpense = 0;
        $sumDebitYearExpense = 0;
        
        //expense&income
        $profitAndLoss = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS accountName"),'sub_accounts.transaction_id as accountId',
        'main_accounts.account_name as type');
        
        $profitAndLoss = $profitAndLoss->where(function ($query) {
            $query->where('main_accounts.account_name','Expenditure');
            $query->orWhere('main_accounts.account_name','Income');
        });  
        $profitAndLoss = $profitAndLoss->where(function ($query) {
            $query->where('degree',AccountType::Normal);
            $query->orWhere('degree',AccountType::PayAndReceive);
        })->get();

        foreach($profitAndLoss as $value)
        {
            $creditSum = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('transaction_details.amount');
    
            $debitSum = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('date',[$fromDate, $toDate])
            ->sum('transaction_details.amount');   

            if($value->type=='Income')
            {    
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

                $sumCreditIncome += $value->credit;

            }else{
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

                $sumDebitExpense += $value->debit;
            
            }
            
            //Yearwise result
            $creditSumYear = TransactionDetails::where('credit_account',$value->accountId)
            ->whereBetween('date',[$fromDateYear, $toDate])
            ->sum('transaction_details.amount');
    
            $debitSumYear = TransactionDetails::where('debit_account',$value->accountId)
            ->whereBetween('date',[$fromDateYear, $toDate])
                ->sum('transaction_details.amount');   

                if($value->type=='Income')
                {    
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

                    $sumCreditYearIncome += $value->creditYear;
    
                }else{
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
    
                    $sumDebitYearExpense += $value->debitYear;
                
                }
            }

            if($sumCreditIncome>=$sumDebitExpense)
            {
                $result = 'Profit';
                
                $resultAmount = $sumCreditIncome - $sumDebitExpense;
            }else{
                $result = 'Loss';
                
                $resultAmount = $sumDebitExpense - $sumCreditIncome;
            }
            
            if($sumCreditYearIncome>=$sumDebitYearExpense)
            {
                $resultYear = 'Profit';
                
                $resultAmountYear = $sumCreditYearIncome - $sumDebitYearExpense;
            }else{
                $resultYear = 'Loss';
                
                $resultAmountYear = $sumDebitYearExpense - $sumCreditYearIncome;
            }

        $today = Carbon::now()->format('d-F-Y');

        $pdf = PDF::loadView('pdf.profitAndLossPdf',['profitAndLoss'=>$profitAndLoss,'today'=>$today,
        'sumCreditIncome'=>$sumCreditIncome,'sumDebitExpense'=>$sumDebitExpense,
        'sumCreditYearIncome'=>$sumCreditYearIncome,'sumDebitYearExpense'=>$sumDebitYearExpense,
        'name'=>$name,'date'=>$showDate,'month'=>$showMonth,'year'=>$showYear,'result'=>$result,
        'resultAmount'=>$resultAmount,'resultYear'=>$resultYear,'resultAmountYear'=>$resultAmountYear]);

        //  download PDF file with download method
        return $pdf->download('profitAndLoss.pdf');
    }
}