<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\SetupAccounts;
use App\Models\TransactionDetails;
use Illuminate\Support\Facades\DB;
use App\Common\AccountType;
use App\Models\SubAccounts;
use Carbon\Carbon;
use PDF;

class BankReconciliationController extends Controller
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

    public function reconciliationMenu()
    {
        $name = Auth::user()->user_name;

        $bankAccounts = SetupAccounts::leftjoin('sub_accounts','sub_accounts.transaction_id','setup_accounts.account_id')
        ->where('setup_accounts.bank_status','=',1)
        ->where('setup_accounts.account_id','!=',null)
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',setup_accounts.account_type,')') AS label"),'setup_accounts.account_id as value')
        ->get();
        return view('reconciliation.createReconciliation',['name'=>$name,'bankAccounts'=>$bankAccounts]);
    }

    public function checkReconciliation(Request $request)
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

        $transactionDetails = TransactionDetails::where('credit_account',$request->accountId)
        ->orwhere('debit_account',$request->accountId)
        ->whereBetween('created_at',[$fromDate, $toDate])
        ->select('transaction_details.*',DB::raw('DATE_FORMAT(transaction_details.date, "%d-%m-%Y") as date'))
        ->get();    

        foreach($transactionDetails as $transaction)
        {
            if($transaction->credit_account==$request->accountId)
            {
                $transaction->credit = $transaction->amount;
                $transaction->debit = 0;

            }elseif($transaction->debit_account==$request->accountId)
            {
                $transaction->credit = 0;
                $transaction->debit = $transaction->amount;
            }
        }

        $creditAmount = TransactionDetails::where('credit_account',$request->accountId)
        ->whereBetween('created_at',[$fromDate, $toDate])
        ->select('transaction_details.*',DB::raw('DATE_FORMAT(transaction_details.date, "%d-%m-%Y") as date'))
        ->sum('amount'); 

        $debitAmount = TransactionDetails::where('debit_account',$request->accountId)
        ->whereBetween('created_at',[$fromDate, $toDate])
        ->select('transaction_details.*',DB::raw('DATE_FORMAT(transaction_details.date, "%d-%m-%Y") as date'))
        ->sum('amount'); 
        
        $runningBalance = $debitAmount - $creditAmount;

        return view('reconciliation.reconciliationResult',['name'=>$name,'result'=>$transactionDetails,
        'runningBalance'=>$runningBalance,'accountId'=>$request->accountId,'from'=>$from,'to'=>$to]);
    }

    public function bankReconciliationPdf(Request $request)
    {

        $from = $request->fromDate;
        $to = $request->toDate;
        $fromDate = date('Y-m-d', strtotime($from)) . ' 00:00:00';
        $toDate = date('Y-m-d', strtotime($to)) . ' 23:59:59';

        $transactionDetails = TransactionDetails::where('credit_account',$request->accountId)
        ->orwhere('debit_account',$request->accountId)
        ->whereBetween('created_at',[$fromDate, $toDate])
        ->select('transaction_details.*',DB::raw('DATE_FORMAT(transaction_details.date, "%d-%m-%Y") as date'))
        ->get(); 
        
        $subAccount = SubAccounts::where('transaction_id',$request->accountId)->value('account_name');

        foreach($transactionDetails as $transaction)
        {
            if($transaction->credit_account==$request->accountId)
            {
                $transaction->credit = $transaction->amount;
                $transaction->debit = 0;

            }elseif($transaction->debit_account==$request->accountId)
            {
                $transaction->credit = 0;
                $transaction->debit = $transaction->amount;
            }
        }

        $creditAmount = TransactionDetails::where('credit_account',$request->accountId)
        ->whereBetween('created_at',[$fromDate, $toDate])
        ->select('transaction_details.*',DB::raw('DATE_FORMAT(transaction_details.date, "%d-%m-%Y") as date'))
        ->sum('amount'); 

        $debitAmount = TransactionDetails::where('debit_account',$request->accountId)
        ->whereBetween('created_at',[$fromDate, $toDate])
        ->select('transaction_details.*',DB::raw('DATE_FORMAT(transaction_details.date, "%d-%m-%Y") as date'))
        ->sum('amount'); 
        
        $runningBalance = $debitAmount - $creditAmount;

        $today = Carbon::now()->format('d-F-Y');

        $pdf = PDF::loadView('pdf.bankReconciliation',['today'=>$today,'result'=>$transactionDetails,
        'runningBalance'=>$runningBalance,'subAccount'=>$subAccount]);

        //  download PDF file with download method
        return $pdf->download('BankReconciliation.pdf');

    }
}
