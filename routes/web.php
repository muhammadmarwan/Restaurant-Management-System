<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//login page 
Route::get('/', [App\Http\Controllers\AuthController::class, 'loginPage'])->name('login');

//check login
Route::post('/login',[App\Http\Controllers\AuthController::class, 'checkLogin'])->name('loginCheck');

Route::group(['middleware' => ['auth']], function () { 

    //demo test page
    Route::get('/demoTestPage',[App\Http\Controllers\VendorController::class, 'demoTestPage'])->name('demoTestPage');

    //view dashboard after login
    Route::get('/index',[App\Http\Controllers\AuthController::class, 'viewDashboard'])->name('dashboard');

    //logout user
    Route::get('/logout',[App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    //view user registration page
    Route::get('/user/create', [App\Http\Controllers\UserRegistrationController::class, 'index'])->name('userRegForm');

    //store user registration details
    Route::post('/store',[App\Http\Controllers\UserRegistrationController::class, 'storeUser'])->name('store');

    //view user registration details
    Route::get('/view',[App\Http\Controllers\UserRegistrationController::class, 'userView'])->name('view');
    Route::post('/view',[App\Http\Controllers\UserRegistrationController::class, 'userView'])->name('view');
    Route::get('/editUser/{id}',[App\Http\Controllers\UserRegistrationController::class, 'userEdit'])->name('editUser');
    Route::post('/updateUser',[App\Http\Controllers\UserRegistrationController::class, 'updateUserDetails'])->name('updateUser');
    
    //delete user
    Route::post('/deleteUser',[App\Http\Controllers\UserRegistrationController::class, 'deleteUser'])->name('deleteUser');

    //password change
    Route::post('/changeUserPassword',[App\Http\Controllers\UserRegistrationController::class, 'changeUserPassword'])->name('changeUserPassword');

    //user permission
    Route::get('/userPermission',[App\Http\Controllers\UserPermissionController::class, 'viewUserPermission'])->name('viewUserPermission');
    Route::post('/userPermissionUpdate',[App\Http\Controllers\UserPermissionController::class, 'userPermissionUpdate'])->name('userPermissionUpdate');

    //create user role
    Route::post('/storeUserRole',[App\Http\Controllers\UserPermissionController::class, 'storeUserRole'])->name('storeUserRole');

    //change password
    Route::get('/passwordChange',[App\Http\Controllers\AuthController::class, 'viewChangePassword'])->name('passChangeView');
    Route::post('/changePassword',[App\Http\Controllers\AuthController::class, 'changePassword'])->name('passChange');

    //create product management
    Route::get('/productCategory',[App\Http\Controllers\ProductManagementController::class, 'productCategory'])->name('productCategory');
    Route::get('/product',[App\Http\Controllers\ProductManagementController::class, 'createProduct'])->name('product');
    Route::post('/storeCategory',[App\Http\Controllers\ProductManagementController::class, 'storeCategory'])->name('storeCategory');
    Route::post('/storeProduct',[App\Http\Controllers\ProductManagementController::class, 'storeProduct'])->name('storeProduct');
    Route::get('/productList',[App\Http\Controllers\ProductManagementController::class, 'productList'])->name('productList');
    Route::get('/mainAccounts',[App\Http\Controllers\MainAccountsController::class, 'viewMainAccounts'])->name('mainAccountsView');
    Route::get('/subAccounts',[App\Http\Controllers\MainAccountsController::class, 'viewSubAccounts'])->name('subAccountsView');
    Route::get('/subAccountsCreate', [App\Http\Controllers\MainAccountsController::class, 'createSubAccounts'])->name('createSubAccounts');
    Route::post('/subAccountsStore', [App\Http\Controllers\MainAccountsController::class, 'storeSubAccounts'])->name('storeSubAccounts');
    Route::post('/deleteSubAccount', [App\Http\Controllers\MainAccountsController::class, 'deleteSubAccount'])->name('deleteSubAccount');

    //product update
    Route::post('/productUpdate', [App\Http\Controllers\ProductManagementController::class, 'productUpdate'])->name('updateProduct');
    Route::post('/productDelete', [App\Http\Controllers\ProductManagementController::class, 'deleteProduct'])->name('deleteProduct');

    //stock details
    Route::get('/stockDetails', [App\Http\Controllers\StockManagementController::class,'stockDetails'])->name('productStock');
    
    //price update
    Route::post('/priceUpdate', [App\Http\Controllers\StockManagementController::class,'priceUpdate'])->name('priceUpdate');

    //product barcode
    Route::get('/barcodeList', [App\Http\Controllers\ProductManagementController::class, 'barcodeList'])->name('barcodeList');

    //productSearch
    Route::get('/searchProduct', [App\Http\Controllers\ProductManagementController::class, 'searchProduct'])->name('searchProduct');

    //account setup 
    Route::get('/setupAccount', [App\Http\Controllers\AccountSetupController::class, 'viewSetupPage'])->name('setupAccount');
    Route::post('/setup', [App\Http\Controllers\AccountSetupController::class, 'storeSetupDetails'])->name('storeSetupAccount');
    
    //purchase
    Route::get('/purchaseEntryPage', [App\Http\Controllers\PurchaseController::class, 'purchaseEntryPage'])->name('purchaseEntryPage');
    Route::post('/purchaseEntry/store', [App\Http\Controllers\PurchaseController::class, 'purchaseEntryStore'])->name('purchaseEntryStore');
    Route::get('/purchaseInventory', [App\Http\Controllers\PurchaseController::class, 'purchaseInventoryViewPage'])->name('purchaseInventory');
    Route::post('/inventoryProduct/store',[App\Http\Controllers\PurchaseController::class, 'purchaseInventoryProductCart']);
    Route::post('/inventory/store',[App\Http\Controllers\PurchaseController::class, 'purchaseInventoryStore'])->name('inventoryStore');
    Route::get('/inventory/clear',[App\Http\Controllers\PurchaseController::class, 'clearInventoryCart'])->name('clearInventoryCart');
    Route::get('/purchaseSetup',[App\Http\Controllers\PurchaseController::class, 'purchaseSetup'])->name('purchaseSetup');
    Route::post('/storePurchaseSetup',[App\Http\Controllers\PurchaseController::class, 'storePurchaseSetup'])->name('storePurchaseSetup');

    //purchase edit
    Route::get('/editPurchase',[App\Http\Controllers\PurchaseController::class, 'editPurchase'])->name('editPurchase');
    Route::post('/updatePurchaseEntry',[App\Http\Controllers\PurchaseController::class, 'updatePurchaseEntry'])->name('updatePurchaseEntry');
    Route::post('/deletePurchaseEntry',[App\Http\Controllers\PurchaseController::class, 'deletePurchaseEntry'])->name('deletePurchaseEntry');
    
    //inventory products
    Route::post('/inventory/products',[App\Http\Controllers\PurchaseController::class, 'inventoryProducts'])->name('inventoryProducts');

    //purchase history
    Route::get('/purchaseHistory',[App\Http\Controllers\PurchaseController::class, 'purchaseHistory'])->name('purchaseHistory');
    Route::get('/printPurchaseBill', [App\Http\Controllers\PurchaseController::class, 'printPurchaseBill'])->name('printPurchaseBill');
    
    //purchase return
    Route::get('/purchaseReturn', [App\Http\Controllers\PurchaseController::class, 'purchaseReturn'])->name('purchaseReturn');
    Route::post('/purchaseReturnCheck', [App\Http\Controllers\PurchaseController::class, 'purchaseReturnCheck'])->name('purchaseReturnCheck');
    
    //purchase details
    Route::get('/viewDetails', [App\Http\Controllers\PurchaseController::class, 'viewDetails'])->name('viewDetails');

    //payment 
    Route::get('/paymentPurchase', [App\Http\Controllers\PaymentController::class, 'purchasePayment'])->name('paymentPurchase');
    Route::post('/paymentPurchase/store', [App\Http\Controllers\PaymentController::class, 'storePurchasePayment'])->name('storePurchasePayment');

    //print payment bill
    Route::get('/printPaymentBill/{id}', [App\Http\Controllers\PaymentController::class, 'printPaymentBill'])->name('printPaymentBill');
    
    //payment history
    Route::get('/paymentHistory', [App\Http\Controllers\PaymentController::class, 'viewPaymentHistory'])->name('viewPaymentHistory');

    //payment history search
    Route::get('/paymentHistorySearch', [App\Http\Controllers\PaymentController::class, 'paymentHistorySearch'])->name('paymentHistorySearch');

    //create vendor
    Route::get('/createVendor', [App\Http\Controllers\VendorController::class, 'vendorRegistration'])->name('createVendorView');
    Route::post('/storeVendor', [App\Http\Controllers\VendorController::class, 'storeVendorDetails'])->name('storeVendor');
    Route::get('/viewVendor', [App\Http\Controllers\VendorController::class, 'viewVendorList'])->name('viewVendorList');
    Route::post('/vendorUpdate', [App\Http\Controllers\VendorController::class, 'vendorUpdate'])->name('vendorUpdate');

    Route::get('/viewGeneralLedger', [App\Http\Controllers\GeneralLedgerController::class, 'viewGeneralLedger'])->name('viewGeneralLedger');
    Route::post('/generalLedgerResult', [App\Http\Controllers\GeneralLedgerController::class, 'generalLedgerResult'])->name('generalLedgerResult');

    Route::get('/viewSubsidiaryLedger', [App\Http\Controllers\GeneralLedgerController::class, 'viewSubsidiaryLedger'])->name('viewSubsidiaryLedger');
    Route::post('/subsidaryLedger', [App\Http\Controllers\GeneralLedgerController::class, 'subsidaryLedgerResult'])->name('subsidaryLedgerResult');

    //journal voucher
    Route::get('/journalVoucher', [App\Http\Controllers\JournalEntryController::class, 'journalVoucher'])->name('journalVoucher');
    Route::post('/journalVoucher/store', [App\Http\Controllers\JournalEntryController::class, 'storeJournalVoucher'])->name('storeJournalVoucher');
    Route::get('/journalVoucher/list', [App\Http\Controllers\JournalEntryController::class, 'listJournal'])->name('listJournal');

    //trial balance
    Route::get('/trialBalance', [App\Http\Controllers\TrialBalanceController::class, 'trialBalance'])->name('trialBalance');
    Route::post('/trialBalanceResult', [App\Http\Controllers\TrialBalanceController::class, 'trialBalanceResult'])->name('trialBalanceResult');
    Route::post('/trialBalanceView', [App\Http\Controllers\TrialBalanceController::class, 'trialBalanceView'])->name('trialBalanceView');
    Route::get('/printTrialBalance', [App\Http\Controllers\TrialBalanceController::class, 'exportToPdf'])->name('printTrialBalance');
    
    //profit and loss
    Route::get('/profitAndLoss', [App\Http\Controllers\ProfitAndLossController::class, 'profitAndLoss'])->name('profitAndLoss');
    Route::post('/profitAndLossResult', [App\Http\Controllers\ProfitAndLossController::class, 'viewProfitAndLoss'])->name('viewProfitAndLoss');
    Route::get('/printProfitAndLoss', [App\Http\Controllers\ProfitAndLossController::class, 'printProfitAndLoss'])->name('printProfitAndLoss');

    //balance sheet
    Route::get('/balanceSheet', [App\Http\Controllers\BalanceSheetController::class, 'balanceSheet'])->name('balanceSheet');
    Route::post('/balanceSheetResult', [App\Http\Controllers\BalanceSheetController::class, 'viewBalanceSheet'])->name('viewBalanceSheet');
    Route::get('/printBalanceSheet', [App\Http\Controllers\BalanceSheetController::class, 'balanceSheetPdf'])->name('printBalanceSheet');

    //pettycash voucher
    Route::get('/pettyCash', [App\Http\Controllers\PettyCashPaymentController::class, 'pettyCashVoucher'])->name('pettyCashVoucher');
    Route::post('/pettyCash/store', [App\Http\Controllers\PettyCashPaymentController::class, 'storePettyCashVoucher'])->name('pettyCashVoucherStore');
    Route::get('/pettyCashList', [App\Http\Controllers\PettyCashPaymentController::class, 'listPettyCash'])->name('listPettyCash');
    Route::get('/setupPettyCash', [App\Http\Controllers\PettyCashPaymentController::class, 'setupPettyCash'])->name('setupPettyCash');
    Route::post('/setupPettyCashStore', [App\Http\Controllers\PettyCashPaymentController::class, 'setupPettyCashStore'])->name('setupPettyCashStore');

    //BankPayment
    Route::get('/bankPayment', [App\Http\Controllers\BankPaymentController::class, 'viewBankPayment'])->name('viewBankPayment');
    Route::post('/bankPayment/store', [App\Http\Controllers\BankPaymentController::class, 'storeBankPayment'])->name('storeBankPayment');
    Route::get('/bankPaymentHistory', [App\Http\Controllers\BankPaymentController::class, 'paymentHistory'])->name('bankPaymentHistory');
    Route::get('/bankReceipt', [App\Http\Controllers\BankPaymentController::class, 'bankReceipt'])->name('bankReceipt');
    Route::post('/bankReceipt/store', [App\Http\Controllers\BankPaymentController::class, 'storeBankReceipt'])->name('storeBankReceipt');
    Route::get('/bankHistoryPdf', [App\Http\Controllers\BankPaymentController::class, 'bankHistoryPdf'])->name('bankHistoryPdf');

    //sales menu
    Route::get('/salesMenu', [App\Http\Controllers\SalesController::class, 'viewMenu'])->name('sales');
    Route::post('/storeSales', [App\Http\Controllers\SalesController::class, 'storeSales'])->name('storeSales');
    Route::get('/viewReciept', [App\Http\Controllers\SalesController::class, 'viewReciept'])->name('viewReciept');

    //sales Restaurant
    Route::get('/salesRestaurant', [App\Http\Controllers\SalesController::class, 'salesRestaurant'])->name('salesRestaurant');
    Route::get('/clearItemCart', [App\Http\Controllers\SalesController::class, 'clearItemCart'])->name('clearItemCart');
    Route::get('/salesRestaurant/store', [App\Http\Controllers\SalesController::class, 'storeSalesRestaurant'])->name('storeSalesRestaurant');

    //drawer 
    Route::get('/drawerOpen', [App\Http\Controllers\SalesController::class, 'drawerOpen'])->name('drawerOpen');

    //sales reports
    Route::get('/salesReport', [App\Http\Controllers\SalesController::class, 'salesReport'])->name('salesReport');
    Route::post('/salesReport', [App\Http\Controllers\SalesController::class, 'salesReport'])->name('salesReport');

    //main menu Reports
    Route::get('/salesMainReports', [App\Http\Controllers\SalesController::class, 'salesMainReports'])->name('salesMainReports');

    //sales return 
    Route::get('/salesReturn', [App\Http\Controllers\SalesController::class, 'salesReturn'])->name('salesReturn');
    Route::post('/salesReturn/store', [App\Http\Controllers\SalesController::class, 'storeSalesReturn'])->name('storeSalesReturn');

    //dine table
    Route::get('/dineTableList', [App\Http\Controllers\SalesController::class, 'dineTableList'])->name('dineTableList');
    Route::post('/storeDineTable', [App\Http\Controllers\SalesController::class, 'storeDineTable'])->name('storeDineTable');
    Route::post('/dineTableDelete', [App\Http\Controllers\SalesController::class, 'dineTableDelete'])->name('dineTableDelete');

   
    Route::get('/storeDineOrder/{id}', [App\Http\Controllers\SalesController::class, 'storeDineOrder'])->name('storeDineOrder');
    Route::get('/customerInvoicePrint', [App\Http\Controllers\SalesController::class, 'customerInvoicePrint'])->name('customerInvoicePrint');

    //cancel dine in
    Route::get('/customerInvoiceCancel', [App\Http\Controllers\SalesController::class, 'customerInvoiceCancel'])->name('customerInvoiceCancel');
    
    //take away sale
    Route::get('/takeAwaySale', [App\Http\Controllers\SalesController::class, 'takeAwaySale'])->name('takeAwaySale');
    Route::get('/takeAway', [App\Http\Controllers\SalesController::class, 'takeAway'])->name('takeAway');
    //sale takeaway
    Route::get('/takeAwaySaleStore', [App\Http\Controllers\SalesController::class, 'takeAwaySaleStore'])->name('takeAwaySaleStore');
    //cancel take away
    Route::get('/takeAwayOrderCancel', [App\Http\Controllers\SalesController::class, 'takeAwayOrderCancel'])->name('takeAwayOrderCancel');

    //delivery sale
    Route::post('/deliveryStore', [App\Http\Controllers\SalesController::class, 'deliveryStore'])->name('deliveryStore');
    Route::get('/deliverySaleStore', [App\Http\Controllers\SalesController::class, 'deliverySaleStore'])->name('deliverySaleStore');
    //cancel delivery
    Route::get('/deliveryOrderCancel', [App\Http\Controllers\SalesController::class, 'deliveryOrderCancel'])->name('deliveryOrderCancel');

    //sales REST report
    Route::get('/restaurantSalesReport', [App\Http\Controllers\SalesController::class, 'restaurantSalesReport'])->name('restaurantSalesReport');
    Route::post('/restaurantSalesReport', [App\Http\Controllers\SalesController::class, 'restaurantSalesReport'])->name('restaurantSalesReport');

    Route::get('/salesRestaurantSetup', [App\Http\Controllers\SalesController::class, 'salesRestaurantSetup'])->name('salesRestaurantSetup');
    Route::post('/restaurantSetupStore', [App\Http\Controllers\SalesController::class, 'restaurantSetupStore'])->name('restaurantSetupStore');

    //rest sale close
    Route::get('/restaurantSaleClose', [App\Http\Controllers\SalesController::class, 'restaurantSaleClose'])->name('restaurantSaleClose');

    //daily close sale
    Route::get('/dailySaleClose', [App\Http\Controllers\SalesController::class, 'dailySaleClose'])->name('dailySaleClose');
    
    //sales accounts setup
    Route::get('/salesAccounts', [App\Http\Controllers\SalesController::class, 'salesAccounts'])->name('salesAccounts');
    Route::post('/storeSalesAccounts', [App\Http\Controllers\SalesController::class, 'salesAccountsStore'])->name('storeSalesAccounts');

    //bank reconsiliation
    Route::get('/reconciliationMenu', [App\Http\Controllers\BankReconciliationController::class, 'reconciliationMenu'])->name('reconciliationMenu');
    Route::post('/checkReconciliation', [App\Http\Controllers\BankReconciliationController::class, 'checkReconciliation'])->name('checkReconciliation');
    Route::get('/bankReconciliationPdf', [App\Http\Controllers\BankReconciliationController::class, 'bankReconciliationPdf'])->name('bankReconciliationPdf');

    //items management
    Route::get('/listItems', [App\Http\Controllers\ItemsController::class, 'listItems'])->name('listItems');
    Route::post('/storeItems', [App\Http\Controllers\ItemsController::class, 'storeItems'])->name('storeItems');
    Route::post('/updateItems', [App\Http\Controllers\ItemsController::class, 'updateItems'])->name('updateItems');
    Route::post('/deleteItem', [App\Http\Controllers\ItemsController::class, 'deleteItems'])->name('deleteItem');

    //setup items
    Route::get('/setupItems', [App\Http\Controllers\ItemsController::class, 'setupItems'])->name('setupItems');
    Route::post('/setupItemsStore', [App\Http\Controllers\ItemsController::class, 'setupItemsStore'])->name('setupItemsStore');
   
    //payroll
    Route::get('/employeeList', [App\Http\Controllers\PayrollManagementController::class, 'employeeList'])->name('employeeList');
    Route::post('/employeeStore', [App\Http\Controllers\PayrollManagementController::class, 'employeeStore'])->name('employeeStore');
    Route::get('/employeeEdit', [App\Http\Controllers\PayrollManagementController::class, 'employeeEdit'])->name('employeeEdit');
    Route::post('/employeeUpdate', [App\Http\Controllers\PayrollManagementController::class, 'employeeUpdate'])->name('employeeUpdate');
    Route::post('/deleteEmployee', [App\Http\Controllers\PayrollManagementController::class, 'deleteEmployee'])->name('deleteEmployee');
   
    Route::get('/salary', [App\Http\Controllers\PayrollManagementController::class, 'salary'])->name('salary');
    Route::get('/salarySheet', [App\Http\Controllers\PayrollManagementController::class, 'salarySheet'])->name('salarySheet');
    Route::get('/createSalarySheet', [App\Http\Controllers\PayrollManagementController::class, 'createSalarySheet'])->name('createSalarySheet');
    Route::post('/salarySheetStore', [App\Http\Controllers\PayrollManagementController::class, 'salarySheetStore'])->name('salarySheetStore');

    //sale report
    Route::get('/salaryReport', [App\Http\Controllers\PayrollManagementController::class, 'salaryReport'])->name('salaryReport');
    Route::post('/salaryReportResult', [App\Http\Controllers\PayrollManagementController::class, 'salaryReportResult'])->name('salaryReportResult');
    Route::get('/printSalaryReport', [App\Http\Controllers\PayrollManagementController::class, 'printSalaryReport'])->name('printSalaryReport');

    //setup salary
    Route::get('/salarySetup', [App\Http\Controllers\PayrollManagementController::class, 'salarySetup'])->name('salarySetup');
    Route::post('/storeSalarySetup', [App\Http\Controllers\PayrollManagementController::class, 'storeSalarySetup'])->name('storeSalarySetup');
    Route::get('/salaryPublish', [App\Http\Controllers\PayrollManagementController::class, 'salaryPublish'])->name('salaryPublish');
    
    //print receipt 
    Route::get('/demoPrint', [App\Http\Controllers\SalesController::class, 'demoPrint'])->name('demoPrint');

    //company informations
    Route::get('/companyInformations', [App\Http\Controllers\CompanyInformationsController::class, 'viewCompanyInformations'])->name('companyInformations');
    Route::post('/companyDetailsStore', [App\Http\Controllers\CompanyInformationsController::class, 'storeCompanyDetials'])->name('companyDetailsStore');
    Route::get('/companyInformationsView', [App\Http\Controllers\CompanyInformationsController::class, 'companyInformationsView'])->name('companyInformationsView');
    Route::get('/editCompanyDetails', [App\Http\Controllers\CompanyInformationsController::class, 'editCompanyDetails'])->name('editCompanyDetails');
    Route::post('/updateCompanyDetails', [App\Http\Controllers\CompanyInformationsController::class, 'updateCompanyDetails'])->name('updateCompanyDetails');

    Route::get('/viewKitchenMenu', [App\Http\Controllers\KitchenController::class, 'viewKitchenMenu'])->name('viewKitchenMenu');
    Route::post('/kitchenOrder', [App\Http\Controllers\KitchenController::class, 'readyOrder'])->name('kitchenOrder');

    //stock update
    Route::post('/updateStock', [App\Http\Controllers\StockManagementController::class, 'updateStock'])->name('updateStock');
    Route::get('/printBill', [App\Http\Controllers\ReceiptController::class, 'printBill'])->name('printBill');

    Route::get('/viewTradingAccount', [App\Http\Controllers\TradingAccountController::class, 'viewTradingAccount'])->name('viewTradingAccount');
    Route::post('/cashierChange', [App\Http\Controllers\SalesController::class, 'cashierChange'])->name('cashierChange');
    Route::get('/cashierChangeHistory', [App\Http\Controllers\SalesController::class, 'cashierChangeHistory'])->name('cashierChangeHistory');
    Route::post('/printPurchaseHistory', [App\Http\Controllers\PurchaseController::class, 'printPurchaseHistory'])->name('printPurchaseHistory');

    Route::post('/cashUpdate', [App\Http\Controllers\ReceiptController::class, 'cashUpdate'])->name('cashUpdate');

    Route::get('/printReport', [App\Http\Controllers\ReceiptController::class, 'printReport'])->name('printReport');
    Route::get('/deleteSales', [App\Http\Controllers\ReceiptController::class, 'deleteSales'])->name('deleteSales');

});
    
// Route::get('/mailSend', [App\Http\Controllers\AuthController::class, 'forgetPassword'])->name('forgetPassword');
Route::get('/forgetPassword', [App\Http\Controllers\AuthController::class, 'forgetPassword'])->name('forgetPass');
Route::post('/forgetPasswordOtp', [App\Http\Controllers\AuthController::class, 'forgetPasswordCheck'])->name('forgetPassOtp');
Route::post('/changePass', [App\Http\Controllers\AuthController::class, 'checkOtpAndUpdate'])->name('passChangeForget');    
Route::post('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');