<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\MainAccounts;
use App\Models\SubAccounts;
use App\TransactionId\Transaction;
use App\Common\UserStatus;
use Illuminate\Support\Facades\DB;
use App\Common\AccountType;

class MainAccountsController extends Controller
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

    public function viewMainAccounts()
    {
        $mainAccounts = MainAccounts::all();
        $name = Auth::user()->user_name;

        return view('accounts',['name'=>$name,'accounts'=>$mainAccounts]);
    }

    public function viewSubAccounts()
    {
        $name = Auth::user()->user_name;

        $subAccounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
                        ->where('sub_accounts.status',UserStatus::active)
                        ->select('main_accounts.account_name as mainAccountName','sub_accounts.*')
                        ->orderby('main_accounts.id')->get();

        $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->get();

        return view('subAccounts',['name'=>$name,'subAccounts'=>$subAccounts,'accounts'=>$accounts]);
    }

    public function storeSubAccounts(Request $request)
    {
         this->validate(request(), [
            'accountName' => 'required',
            'mainAccountId' => 'required',
            'accountCode' => 'required',
            'accountBalance' => 'required',
        ]);

        try {
            $subAccount = new SubAccounts();
            $subAccount->transaction_id = Transaction::setTransactionId();
            $subAccount->account_name = $request->accountName;
            $subAccount->parent_account_id = $request->mainAccountId;
            $subAccount->account_code =$request->accountCode;
            $subAccount->balance_amount = $request->accountBalance;
            $subAccount->save();
            
            return redirect('subAccounts')->with('message', 'Created SubAccount Successfully!');                 
        }
        catch (Exception $e){

            return json_encode(array("status" => 300));
        }
    }

    public function setupAccountPage()
    {
        $name = Auth::user()->user_name;
        return view('setupAccounts',['name'=>$name]);
    }

    public function deleteSubAccount(Request $request)
    {
        $delete = SubAccounts::where('id',$request->id)->delete();

        return redirect()->back();
    }
}