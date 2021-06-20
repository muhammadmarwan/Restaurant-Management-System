<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\UserPermission;
use App\TransactionId\Transaction;
use App\Models\UserRole;

class UserPermissionController extends Controller
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

    public function storeUserRole(Request $request)
    {
        $userRoleId = UserRole::max('user_role_id');

        $storeRole = new UserRole();
        $storeRole->transaction_id = Transaction::setTransactionId();
        $storeRole->user_role = $request->userRole;
        $storeRole->user_role_id = $userRoleId +1;
        $storeRole->description = $request->description;
        $storeRole->save();
        
        return redirect('userPermission');
    }

    public function viewUserPermission()
    {
        $userRole = UserRole::where('user_role_id','!=',0)->get();

        $admin = UserPermission::leftjoin('user_roles','user_roles.user_role_id','user_permissions.user_role')
        ->where('user_permissions.user_role',1)
        ->select('user_roles.user_role as roleName','user_permissions.*')->first();

        $accountant = UserPermission::leftjoin('user_roles','user_roles.user_role_id','user_permissions.user_role')
        ->where('user_permissions.user_role',2)
        ->select('user_roles.user_role as roleName','user_permissions.*')->first();

        $cashier = UserPermission::leftjoin('user_roles','user_roles.user_role_id','user_permissions.user_role')
        ->where('user_permissions.user_role',3)
        ->select('user_roles.user_role as roleName','user_permissions.*')->first();

        $name = Auth::user()->user_name;

        return view('userPermissions.userPermission',['name'=>$name,'roles'=>$userRole,'admin'=>$admin,'accountant'=>$accountant,'cashier'=>$cashier]);
    }

    public function userPermissionUpdate(Request $request)
    {
        $userManagement = $request->userManagement;

        if(!isset($userManagement))
        {
            $userManagement = 'off';
        }

        $productManagement = $request->productManagement;

        if(!isset($productManagement))
        {
            $productManagement = 'off';
        }

        $vendorManagement = $request->vendorManagement;

        if(!isset($vendorManagement))
        {
            $vendorManagement = 'off';
        }

        $chartOfAccounts = $request->chartOfAccounts;

        if(!isset($chartOfAccounts))
        {
            $chartOfAccounts = 'off';
        }

        $purchaseModule = $request->purchaseModule;

        if(!isset($purchaseModule))
        {
            $purchaseModule = 'off';
        }

        $paymentModule = $request->paymentModule;

        if(!isset($paymentModule))
        {
            $paymentModule = 'off';
        }

        $ledger = $request->ledger;

        if(!isset($ledger))
        {
            $ledger = 'off';
        }

        $journal = $request->journal;

        if(!isset($journal))
        {
            $journal = 'off';
        }

        $trialBalance = $request->trialBalance;

        if(!isset($trialBalance))
        {
            $trialBalance = 'off';
        }

        $profitAndLoss = $request->profitAndLoss;

        if(!isset($profitAndLoss))
        {
            $profitAndLoss = 'off';
        }

        $balanceSheet = $request->balanceSheet;

        if(!isset($balanceSheet))
        {
            $balanceSheet = 'off';
        }

        $pettyCash = $request->pettyCash;

        if(!isset($pettyCash))
        {
            $pettyCash = 'off';
        }

        $bankPayment = $request->bankPayment;

        if(!isset($bankPayment))
        {
            $bankPayment = 'off';
        }

        $bankReconciliation = $request->bankReconciliation;

        if(!isset($bankReconciliation))
        {
            $bankReconciliation = 'off';
        }

        $payroll = $request->payroll;

        if(!isset($payroll))
        {
            $payroll = 'off';
        }

        $stock = $request->stock;

        if(!isset($stock))
        {
            $stock = 'off';
        }

        $restaurantSetup = $request->restaurantSetup;

        if(!isset($restaurantSetup))
        {
            $restaurantSetup = 'off';
        }

        $userPermissionCheck = UserPermission::where('user_role',$request->userRole)->delete();

        $userPermission = new UserPermission();
        $userPermission->transaction_id = Transaction::setTransactionId();
        $userPermission->user_role = $request->userRole;
        $userPermission->user_management = $userManagement;
        $userPermission->product_management = $productManagement;
        $userPermission->chart_of_accounts = $chartOfAccounts;
        $userPermission->vendor_management = $vendorManagement;
        $userPermission->purchase = $purchaseModule;
        $userPermission->payment = $paymentModule;
        $userPermission->ledger = $ledger;
        $userPermission->journal = $journal;
        $userPermission->trial_balance = $trialBalance;
        $userPermission->profit_and_loss = $profitAndLoss;
        $userPermission->balance_sheet = $balanceSheet;
        $userPermission->petty_cash = $pettyCash;
        $userPermission->bank_payment = $bankPayment;

        $userPermission->bank_reconciliation = $bankReconciliation;
        $userPermission->payroll = $payroll;
        $userPermission->stock = $stock;
        $userPermission->restaurant_setup = $restaurantSetup;

        $userPermission->save();

        return redirect('userPermission')->with('message', 'User Permission Updated Successfully!');    
    }
}
