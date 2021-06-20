<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\SetupAccounts;
use App\Models\TransactionDetails;
use App\TransactionId\Transaction;
use App\Common\TransactionType;
use App\Models\SubAccounts;
use Illuminate\Support\Facades\DB;
use App\Common\AccountType;
use App\Models\BankTransaction;
use Carbon\Carbon;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class BankPaymentController extends Controller
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

    public function viewBankPayment()
    {
        $name = Auth::user()->user_name;
        
        $bankAccounts = SetupAccounts::where('bank_status','=',1)
        ->where('account_id','!=',null)
        ->select('account_type as label','account_id as value')->get();

        $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->get();

        return view('bankPayment.bankPayment',['name'=>$name,'bankAccounts'=>$bankAccounts,'accounts'=>$accounts]);
    }

    public function paymentHistory()
    {
        $name = Auth::user()->user_name;

        $bankPayment = BankTransaction::leftjoin('transaction_details','bank_transactions.transaction_details_id','transaction_details.transaction_id')
        ->leftjoin('setup_accounts','setup_accounts.account_id','bank_transactions.bank_account')
        ->leftjoin('sub_accounts','sub_accounts.transaction_id','bank_transactions.account_id')
        ->select('setup_accounts.account_type as bankAccount','sub_accounts.account_name as accountId',
        DB::raw('DATE_FORMAT(bank_transactions.date, "%d-%m-%Y") as paymentDate'),'bank_transactions.*')
        ->latest()->get();

        return view('bankPayment.paymentHistory',['name'=>$name,'bankPayment'=>$bankPayment]);
    }

    public function storeBankPayment(Request $request)
    {
        $this->validate(request(), [
            'bankAccount' => 'required',
            'accountId' => 'required',
            'amount' => 'required',
            'billNo' => 'required',
            'narration' => 'required',
            'date' => 'required',

        ]);
        //create transaction
        $transaction = new TransactionDetails();
        $transaction->transaction_id = Transaction::setTransactionId();
        $transaction->type = TransactionType::payment;
        $transaction->credit_account = $request->bankAccount;
        $transaction->debit_account = $request->accountId;
        $transaction->amount = $request->amount;
        $transaction->bill_no = $request->billNo;
        $transaction->narration = $request->narration;
        $transaction->date = $request->date;
        $transaction->save();

        //store bank payment
        $bankPayment = new BankTransaction();
        $bankPayment->transaction_id = Transaction::setTransactionId();
        $bankPayment->transaction_type = 'Debit';
        $bankPayment->bank_account = $request->bankAccount;
        $bankPayment->account_id = $request->accountId;
        $bankPayment->bill_no = $request->billNo;
        $bankPayment->amount = $request->amount;
        $bankPayment->date = $request->date;
        $bankPayment->narration = $request->narration;
        $bankPayment->transaction_details_id = $transaction->transaction_id;
        $bankPayment->save();

        Alert::success('Success','Added Payment Voucher');
        return redirect('bankPaymentHistory'); 

    }

    public function bankReceipt()
    {
        $name = Auth::user()->user_name;

        $bankAccounts = SetupAccounts::where('bank_status','=',1)
        ->where('account_id','!=',null)
        ->select('account_type as label','account_id as value')->get();

        $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->get();

        return view('bankPayment.bankReceipt',['name'=>$name,'bankAccounts'=>$bankAccounts,'accounts'=>$accounts]);
    }

    public function storeBankReceipt(Request $request)
    {
        $this->validate(request(), [
            'bankAccount' => 'required',
            'accountId' => 'required',
            'amount' => 'required',
            'billNo' => 'required',
            'narration' => 'required',
            'date' => 'required',

        ]);
        //create transaction
        $transaction = new TransactionDetails();
        $transaction->transaction_id = Transaction::setTransactionId();
        $transaction->type = TransactionType::payment;
        $transaction->credit_account = $request->accountId;
        $transaction->debit_account = $request->bankAccount;
        $transaction->amount = $request->amount;
        $transaction->bill_no = $request->billNo;
        $transaction->narration = $request->narration;
        $transaction->date = $request->date;
        $transaction->save();

        //store bank receipt
        $bankTransaction = new BankTransaction();
        $bankTransaction->transaction_id = Transaction::setTransactionId();
        $bankTransaction->transaction_type = 'Credit';
        $bankTransaction->account_id = $request->accountId;
        $bankTransaction->bank_account = $request->bankAccount;
        $bankTransaction->bill_no = $request->billNo;
        $bankTransaction->amount = $request->amount;
        $bankTransaction->date = $request->date;
        $bankTransaction->narration = $request->narration;
        $bankTransaction->transaction_details_id = $transaction->transaction_id;
        $bankTransaction->save();

        Alert::success('Success','Added Receipt Voucher');
        return redirect('bankPaymentHistory'); 

    }

    public function bankHistoryPdf()
    {
        $bankPayment = BankTransaction::leftjoin('transaction_details','bank_transactions.transaction_details_id','transaction_details.transaction_id')
        ->leftjoin('setup_accounts','setup_accounts.account_id','bank_transactions.bank_account')
        ->leftjoin('sub_accounts','sub_accounts.transaction_id','bank_transactions.account_id')
        ->select('setup_accounts.account_type as bankAccount','sub_accounts.account_name as accountId',
        DB::raw('DATE_FORMAT(bank_transactions.date, "%d-%m-%Y") as paymentDate'),'bank_transactions.*')
        ->latest()->get();

        $today = Carbon::now()->format('d-F-Y');

        $pdf = PDF::loadView('pdf.bankHistory',['today'=>$today,'bankPayment'=>$bankPayment]);

        //  download PDF file with download method
        return $pdf->download('BankHistory.pdf');
    }
}