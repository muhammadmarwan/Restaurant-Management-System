@extends("layouts.admin")

@section("page-content")

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<div class="container">
<div class="card-header">
                <h1 class="card-title"><b>User Permissions</b></h1>
                <!-- <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Create New User Role</button>
              </div> -->
              </div>
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active show" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">Admin</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Accountant</a>
                  </li>
                  <!-- <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Cashier</a>
                  </li> -->
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">                     
                  <form method ="post" action="{{ Route('userPermissionUpdate') }}">
                     @CSRF
                     <input type="hidden" name="userRole" value="1">
                    <table class="table">
                     <tr>
                     <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">User Management</label></td>
                        @if($admin->user_management=='on')
                        <td><input type="checkbox"  name="userManagement" checked="checked" onclick="return false;"></td>
                        @endif
                        @if($admin->user_management=='off')
                        <td><input type="checkbox"  name="userManagement" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Product Management</label></td>
                        @if($admin->product_management=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="productManagement" checked="checked"onclick="return false;"></td>
                        @endif
                        @if($admin->product_management=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="productManagement" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Vendor Management</label></td>
                        @if($admin->vendor_management=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="vendorManagement" checked="checked" onclick="return false;"></td>
                        @endif
                        @if($admin->vendor_management=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="vendorManagement" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Chart Of Accounts</label></td>
                        @if($admin->chart_of_accounts=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="chartOfAccounts" checked="checked" onclick="return false;"></td>
                        @endif
                        @if($admin->chart_of_accounts=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="chartOfAccounts" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>

                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Bank Reconciliation</label></td>
                        @if($admin->bank_reconciliation=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="bankReconciliation" checked="checked"></td>
                        @endif
                        @if($admin->bank_reconciliation=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="chartOfAccounts" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>

                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Payroll</label></td>
                        @if($admin->payroll=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="payroll" checked="checked"></td>
                        @endif
                        @if($admin->payroll=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="chartOfAccounts" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>

                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Stock</label></td>
                        @if($admin->stock=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="stock" checked="checked"></td>
                        @endif
                        @if($admin->stock=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="chartOfAccounts" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>

                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Restaurant Setup</label></td>
                        @if($admin->restaurant_setup=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="restaurantSetup" checked="checked"></td>
                        @endif
                        @if($admin->restaurant_setup=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="chartOfAccounts" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>

                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Purchase Module</label></td>
                        @if($admin->purchase=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="purchaseModule" checked="checked" onclick="return false;"></td>
                        @endif
                        @if($admin->purchase=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="purchaseModule" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Payment Module</label></td>
                        @if($admin->payment=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="paymentModule" checked="checked" onclick="return false;"></td>
                        @endif
                        @if($admin->payment=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="paymentModule" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Ledger</label></td>
                        @if($admin->ledger=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="ledger" checked="checked" onclick="return false;"></td>
                        @endif
                        @if($admin->ledger=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="ledger" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Journal</label></td>
                        @if($admin->journal=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="journal" checked="checked" onclick="return false;"></td>
                        @endif
                        @if($admin->journal=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="journal" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Trial Balance</label></td>
                        @if($admin->trial_balance=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="trialBalance" checked="checked" onclick="return false;"></td>
                        @endif
                        @if($admin->trial_balance=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="trialBalance" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Profit And Loss</label></td>
                        @if($admin->profit_and_loss=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="profitAndLoss" checked="checked" onclick="return false;"></td>
                        @endif
                        @if($admin->profit_and_loss=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="profitAndLoss" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Balance Sheet</label></td>
                        @if($admin->balance_sheet=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="balanceSheet" checked="checked" onclick="return false;"></td>
                        @endif
                        @if($admin->balance_sheet=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="balanceSheet" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Petty Cash</label></td>
                        @if($admin->petty_cash=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="pettyCash" checked="checked" onclick="return false;"></td>
                        @endif
                        @if($admin->petty_cash=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="pettyCash" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Bank Payment</label></td>
                        @if($admin->bank_payment=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="bankPayment" checked="checked" onclick="return false;"></td>
                        @endif
                        @if($admin->bank_payment=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="bankPayment" onclick="return false;"></td>
                        @endif
                      </div>
                      </tr>
                      </table>
                      <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                  </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                  <form method ="post" action="{{ Route('userPermissionUpdate') }}">
                     @CSRF
                     <input type="hidden" name="userRole" value="2">
                    <table class="table">
                     <tr>
                     <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">User Management</label></td>
                        @if($accountant->user_management=='on')
                        <td><input type="checkbox"  name="userManagement" checked="checked"></td>
                        @endif
                        @if($accountant->user_management=='off')
                        <td><input type="checkbox"  name="userManagement"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Product Management</label></td>
                        @if($accountant->product_management=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="productManagement" checked="checked"></td>
                        @endif
                        @if($accountant->product_management=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="productManagement"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Vendor Management</label></td>
                        @if($accountant->vendor_management=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="vendorManagement" checked="checked"></td>
                        @endif
                        @if($accountant->vendor_management=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="vendorManagement"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Chart Of Accounts</label></td>
                        @if($accountant->chart_of_accounts=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="chartOfAccounts" checked="checked"></td>
                        @endif
                        @if($accountant->chart_of_accounts=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="chartOfAccounts"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Purchase Module</label></td>
                        @if($accountant->purchase=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="purchaseModule" checked="checked"></td>
                        @endif
                        @if($accountant->purchase=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="purchaseModule"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Payment Module</label></td>
                        @if($accountant->payment=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="paymentModule" checked="checked"></td>
                        @endif
                        @if($accountant->payment=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="paymentModule"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Ledger</label></td>
                        @if($accountant->ledger=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="ledger" checked="checked"></td>
                        @endif
                        @if($accountant->ledger=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="ledger"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Journal</label></td>
                        @if($accountant->journal=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="journal" checked="checked"></td>
                        @endif
                        @if($accountant->journal=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="journal"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Trial Balance</label></td>
                        @if($accountant->trial_balance=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="trialBalance" checked="checked"></td>
                        @endif
                        @if($accountant->trial_balance=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="trialBalance"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Profit And Loss</label></td>
                        @if($accountant->profit_and_loss=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="profitAndLoss" checked="checked"></td>
                        @endif
                        @if($accountant->profit_and_loss=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="profitAndLoss"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Balance Sheet</label></td>
                        @if($accountant->balance_sheet=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="balanceSheet" checked="checked"></td>
                        @endif
                        @if($accountant->balance_sheet=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="balanceSheet"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Petty Cash</label></td>
                        @if($accountant->petty_cash=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="pettyCash" checked="checked"></td>
                        @endif
                        @if($accountant->petty_cash=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="pettyCash"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Bank Payment</label></td>
                        @if($accountant->bank_payment=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="bankPayment" checked="checked"></td>
                        @endif
                        @if($accountant->bank_payment=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="bankPayment"></td>
                        @endif
                      </div>
                      </tr>
                      </table>
                      <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                  </div>                  
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                  <form method ="post" action="{{ Route('userPermissionUpdate') }}">
                     @CSRF
                     <input type="hidden" name="userRole" value="3">
                    <table class="table">
                     <tr>
                     <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">User Management</label></td>
                        @if($cashier->user_management=='on')
                        <td><input type="checkbox"  name="userManagement" checked="checked"></td>
                        @endif
                        @if($cashier->user_management=='off')
                        <td><input type="checkbox"  name="userManagement"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Product Management</label></td>
                        @if($cashier->product_management=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="productManagement" checked="checked"></td>
                        @endif
                        @if($cashier->product_management=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="productManagement"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Vendor Management</label></td>
                        @if($cashier->vendor_management=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="vendorManagement" checked="checked"></td>
                        @endif
                        @if($cashier->vendor_management=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="vendorManagement"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Chart Of Accounts</label></td>
                        @if($cashier->chart_of_accounts=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="chartOfAccounts" checked="checked"></td>
                        @endif
                        @if($cashier->chart_of_accounts=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="chartOfAccounts"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Purchase Module</label></td>
                        @if($cashier->purchase=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="purchaseModule" checked="checked"></td>
                        @endif
                        @if($cashier->purchase=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="purchaseModule"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Payment Module</label></td>
                        @if($cashier->payment=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="paymentModule" checked="checked"></td>
                        @endif
                        @if($cashier->payment=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="paymentModule"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Ledger</label></td>
                        @if($cashier->ledger=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="ledger" checked="checked"></td>
                        @endif
                        @if($cashier->ledger=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="ledger"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Journal</label></td>
                        @if($cashier->journal=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="journal" checked="checked"></td>
                        @endif
                        @if($cashier->journal=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="journal"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Trial Balance</label></td>
                        @if($cashier->trial_balance=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="trialBalance" checked="checked"></td>
                        @endif
                        @if($cashier->trial_balance=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="trialBalance"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Profit And Loss</label></td>
                        @if($cashier->profit_and_loss=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="profitAndLoss" checked="checked"></td>
                        @endif
                        @if($cashier->profit_and_loss=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="profitAndLoss"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Balance Sheet</label></td>
                        @if($cashier->balance_sheet=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="balanceSheet" checked="checked"></td>
                        @endif
                        @if($cashier->balance_sheet=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="balanceSheet"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Petty Cash</label></td>
                        @if($cashier->petty_cash=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="pettyCash" checked="checked"></td>
                        @endif
                        @if($cashier->petty_cash=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="pettyCash"></td>
                        @endif
                      </div>
                      </tr>
                      <tr>
                      <div class="icheck-primary d-inline">
                        <td><label for="checkboxPrimary2">Bank Payment</label></td>
                        @if($cashier->bank_payment=='on')
                        <td><input type="checkbox" id="checkboxPrimary2" name="bankPayment" checked="checked"></td>
                        @endif
                        @if($cashier->bank_payment=='off')
                        <td><input type="checkbox" id="checkboxPrimary2" name="bankPayment"></td>
                        @endif
                      </div>
                      </tr>
                      </table>
                      <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                  </div>                  
                    </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
</div>
@endsection