<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\TransactionId\Transaction;
use App\Models\PettyCashPayment;
use App\Common\AccountSetupType;
use App\Models\SetupAccounts;
use App\Models\TransactionDetails;
use App\Common\TransactionType;
use App\Models\SubAccounts;
use Illuminate\Support\Facades\DB;
use App\Common\AccountType;
use App\Models\PettyCashSetup;

class PettyCashPaymentController extends Controller
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

    public function pettyCashVoucher()
    {
        $name = Auth::user()->user_name;

        $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->orWhere('degree',AccountType::PayAndReceive)
        ->get();

        return view('pettyCash.pettyCashVoucher',['name'=>$name,'accounts'=>$accounts]);
    }

    public function listPettyCash()
    {
        $name = Auth::user()->user_name;
        $pettyCash = PettyCashPayment::leftjoin('sub_accounts','sub_accounts.transaction_id','petty_cash_payments.debit_account_id')
        ->select(DB::raw('DATE_FORMAT(petty_cash_payments.date, "%d-%m-%Y") as voucherDate'),'petty_cash_payments.*',
        'sub_accounts.account_name as debitAccount')->get();

        return view('pettyCash.pettyCashList',['name'=>$name,'pettyCash'=>$pettyCash]);
    }

    public function storePettyCashVoucher(Request $request)
    {
        $this->validate(request(), [
            'date' => 'required',
            'amount' => 'required',
            'accountId' => 'required',
            'billNo' => 'required',
            'narration' => 'required',

        ]);

        $cashAccount = PettyCashSetup::where('account_type',1)->value('account_id');

        //create transaction
        $transaction = new TransactionDetails();
        $transaction->transaction_id = Transaction::setTransactionId();
        $transaction->type = TransactionType::payment;
        $transaction->credit_account = $cashAccount;
        $transaction->debit_account = $request->accountId;
        $transaction->amount = $request->amount;
        $transaction->bill_no = $request->billNo;
        $transaction->narration = $request->narration;
        $transaction->date = $request->date;
        $transaction->save();
        
        //petty cash payment
        $pettyCash = new PettyCashPayment();
        $pettyCash->transaction_id = Transaction::setTransactionId();
        $pettyCash->date = $request->date;
        $pettyCash->amount = $request->amount;
        $pettyCash->bill_no = $request->billNo;
        $pettyCash->narration = $request->narration;
        $pettyCash->debit_account_id = $request->accountId;
        $pettyCash->transaction_details_id = $transaction->transaction_id;
        $pettyCash->save();

        return redirect('pettyCashList')->with('message', 'PettyCash Voucher Created');
    }

    public function setupPettyCash()
    {
        $name = Auth::user()->user_name;

        $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->orWhere('degree',AccountType::PayAndReceive)
        ->get();

        $account = PettyCashSetup::where('account_type',1)->count();

        return view('pettyCash.setupPettyCash',['name'=>$name,'accounts'=>$accounts,'setup'=>$account]);
    }

    public function setupPettyCashStore(Request $request)
    {
        $check = PettyCashSetup::where('id',1)->where('account_type',$request->type)->count();

        if($check==0)
        {
            $pettyCash = new PettyCashSetup();
            $pettyCash->transaction_id = Transaction::setTransactionId();
            $pettyCash->account_type = $request->type;
            $pettyCash->account_id = $request->accountId;
            $pettyCash->save();

            return redirect('setupPettyCash')->with('message', 'PettyCash Account Added');
        }else{
            $update = PettyCashSetup::find($request->type);
            $update->account_id = $request->accountId; 
            $update->save();

            return redirect('setupPettyCash')->with('message', 'PettyCash Account Updated');
        }
        

    }
}
