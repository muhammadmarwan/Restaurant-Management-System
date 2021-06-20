<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\SubAccounts;
use App\Common\AccountSetupType;
use App\Models\SetupAccounts;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class AccountSetupController extends Controller
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

    public function viewSetupPage()
    {
        $name = Auth::user()->user_name;

        $setupAccounts = SetupAccounts::get();

        foreach($setupAccounts as $value)
        {
            $selectedAccount = SubAccounts::where('transaction_id',$value->account_id)
            ->value('account_name');

            if($selectedAccount==null)
            {
                $value->selectedAccount = 1;
            }else{
                $value->selectedAccount = $selectedAccount;
            }
        }

        $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->get();

        return view('setupForAccounts',['name'=>$name,'accounts'=>$accounts,'setupAccounts'=>$setupAccounts]);
    }

    public function storeSetupDetails(Request $request)
    {
        $updateAccount = SetupAccounts::where('transaction_id',$request->type_id)
                        ->update(['account_id'=>$request->account,'selected_status'=>0]);
        
        $type = SetupAccounts::where('transaction_id',$request->type_id)->value('account_type');                

        return redirect('setupAccount')->with('message', 'Update '.$type.' Account');
    }
}
