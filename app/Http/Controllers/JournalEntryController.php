<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\SubAccounts; 
use Illuminate\Support\Facades\DB;
use App\Common\AccountType;
use App\TransactionId\Transaction;
use App\Models\JournalVoucher;
use App\Models\TransactionDetails;
use App\Common\TransactionType;

class JournalEntryController extends Controller
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
    public function journalVoucher()
    {
        $name = Auth::user()->user_name;

        $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->get();

        return view('journal.journalVoucher',['name'=>$name,'accounts'=>$accounts]);
    }

    public function storeJournalVoucher(Request $request)
    {
        $this->validate(request(), [
            'fromAccountId' => 'required',
            'toAccountId' => 'required',
            'amount' => 'required',
            'journalNo' => 'required',
            'date' => 'required',
            'narration' => 'required',
        ]);

        $name = Auth::user()->user_name;
        //create transaction
        $transaction = new TransactionDetails();
        $transaction->transaction_id = Transaction::setTransactionId();
        $transaction->type = TransactionType::journalEntry;
        $transaction->credit_account = $request->fromAccountId;
        $transaction->debit_account = $request->toAccountId;
        $transaction->amount = $request->amount;
        $transaction->bill_no = $request->journalNo;
        $transaction->narration = $request->narration;
        $transaction->date = $request->date;
        $transaction->save();

        $journal = new JournalVoucher();
        $journal->transaction_id = Transaction::setTransactionId();
        $journal->from_account = $request->fromAccountId;
        $journal->to_account = $request->toAccountId;
        $journal->journal_no = $request->journalNo;
        $journal->amount = $request->amount;
        $journal->date = $request->date;
        $journal->narration = $request->narration;
        $journal->transaction_details_id = $transaction->transaction_id;
        $journal->save();
             
        //update amount
        $fromAccountBalance = SubAccounts::where('transaction_id',$request->fromAccountId)
        ->value('balance_amount');

        $fromAccountAmount = $fromAccountBalance - $request->amount;

        $fromAccountUpdate = SubAccounts::where('transaction_id',$request->fromAccountId)
        ->update(['balance_amount'=>$fromAccountAmount]);

        $toAccountBalance = SubAccounts::where('transaction_id',$request->toAccountId)
        ->value('balance_amount');

        $toAccountAmount = $toAccountBalance + $request->amount;

        $toAccountUpdate = SubAccounts::where('transaction_id',$request->toAccountId)
        ->update(['balance_amount'=>$toAccountAmount]);

        return redirect('journalVoucher/list')->with('message', 'Journal Entry Added Successfully!'); 
    }

    public function listJournal()
    {
        $name = Auth::user()->user_name;

        $journal = journalVoucher::leftjoin('sub_accounts as from','from.transaction_id','journal_vouchers.from_account')
        ->leftjoin('sub_accounts as to','to.transaction_id','journal_vouchers.to_account','journal_vouchers.to_account')
        ->select(DB::raw('DATE_FORMAT(journal_vouchers.date, "%d-%m-%Y") as voucherDate'),'journal_vouchers.*',
        'from.account_name as fromAccount','to.account_name as toAccount')->get();

        return view('journal.viewJournal',['name'=>$name,'journal'=>$journal]);
    }
}
