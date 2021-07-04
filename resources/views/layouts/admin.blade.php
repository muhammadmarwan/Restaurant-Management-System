<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Easy POS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <link rel="icon" href="{{ asset('dist/img/newLogo.png') }}">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('plugins/ionicons/ionicons.min.css') }}">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="{{ asset('fonts/googleFont/googleFont.css') }}" rel="stylesheet">
  <script src="{{ asset('plugins/jquery/jquery-3.5.1.js') }}" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <style>
   .itemCard:hover {
    -webkit-box-shadow: 3px 3px 5px 6px #ccc; 
    -moz-box-shadow:    3px 3px 5px 6px #ccc;
    box-shadow:         3px 3px 5px 6px #ccc;
    }
  </style>  

  @livewireStyles
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ Route('dashboard') }}" class="nav-link">Home</a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>
    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <ul class="navbar-nav ml-auto">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ Route('salesRestaurant') }}" class="nav-link">
        <button class="btn btn-success">POS</button>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <h4 class="nav-link">@widget('now')</h4>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <strong class="nav-link">{{Carbon\Carbon::today()->format('d-M-Y')}}</strong>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{$name}}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ Route('passChangeView') }}">Change Password</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ Route('logout') }}">Logout</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ Route('dashboard') }}" class="brand-link">
      <img src="{{ asset('dist/img/newLogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">EasyPOS</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="{{ Route('dashboard') }}" class="d-block" style="text-transform: uppercase;">{{$name}} @if(Auth::user()->user_role=1) (Admin) 
          @elseif(Auth::user()->user_role=2) (Accountant) @endif</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
				    <a href="{{ Route('dashboard') }}" class="nav-link ">
				      <i class="nav-icon fas fa-home"></i>
				      <p>Dashboard</p>
				    </a>
				  </li>
          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('user_management','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
				      <i class="nav-icon fas fa-user"></i>
				      <p>User Management
              <i class="fas fa-angle-left right"></i>
              </p>
				    </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('view') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('viewUserPermission') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users Permissions</p>
                </a>
              </li>

              <!-- <li class="nav-item">
                <a href="{{ Route('demoTestPage') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Demo Page</p>
                </a>
              </li> -->
            </ul>
          </li>
          @endif
          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('user_management','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
				      <i class="nav-icon fas fa-building"></i>
				      <p>Company Informations
              <i class="fas fa-angle-left right"></i>
              </p>
				    </a>
            <ul class="nav nav-treeview">
              @if(App\Models\CompanyInformations::count()==0)
              <li class="nav-item">
                <a href="{{ Route('companyInformations') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Setup Company Details</p>
                </a>
              </li>
              @else
              <li class="nav-item">
                <a href="{{ Route('companyInformationsView') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Company Details</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          @endif


          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('restaurant_setup','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
				      <i class="nav-icon fas fa-utensils"></i>
				      <p>Kitchen Menu
              <i class="fas fa-angle-left right"></i>
              </p>
				    </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('viewKitchenMenu') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kitchen Menu</p>
                </a>
              </li>
            </ul>
          </li>
          @endif


          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('payroll','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
				      <i class="nav-icon fas fa-money-check"></i>
				      <p>Payroll Management
              <i class="fas fa-angle-left right"></i>
              </p>
				    </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('employeeList') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Employee</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('salary') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Salary</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('salarySetup') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Salary Setup</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('salaryReport') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Salary Reports</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('sales','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
				      <i class="nav-icon fas fa-shopping-cart"></i>
				      <p>Sales Management
              <i class="fas fa-angle-left right"></i>
              </p>
				    </a>
            <ul class="nav nav-treeview">
              <!-- <li class="nav-item">
                <a href="{{ Route('sales') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Menu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('salesAccounts') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Accounts Setup</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{ Route('salesRestaurant') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Restaurant</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('salesRestaurantSetup') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Restaurant Setup</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('cashierChangeHistory') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cashier History</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('salesMainReports') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Reports</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          
          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('stock','on')->count() != null )
          <li class="nav-item has-treeview">
          <a href="#" class="nav-link ">
				      <i class="nav-icon fas fa-boxes"></i>
				      <p>Stock Management
              <i class="fas fa-angle-left right"></i>
              </p>
				    </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('productStock') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Stock</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('restaurant_setup','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
				      <i class="nav-icon fas fa-utensils"></i>
				      <p>Restaurant Setup
              <i class="fas fa-angle-left right"></i>
              </p>
				    </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('listItems') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Items</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('dineTableList') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dine Tables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('setupItems') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Setup Items</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('setupItems') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tax Setup</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('bank_reconciliation','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-university"></i>
				      <p>Bank
              <i class="fas fa-angle-left right"></i>
              </p>
				    </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('reconciliationMenu') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reconciliation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('viewBankPayment') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bank Payment</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('bankReceipt') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bank Receipt</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('bankPaymentHistory') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payment History</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
                    
          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('product_management','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-box"></i>
				      <p>Product Management
              <i class="fas fa-angle-left right"></i>
              </p>
				    </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ Route('productCategory') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Product Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('productList') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products List</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('chart_of_accounts','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-dollar-sign"></i>
				      <p>Chart Of Accounts
              <i class="fas fa-angle-left right"></i>
              </p>
				    </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('mainAccountsView') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Main Accounts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('subAccountsView') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sub Accounts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('setupAccount') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Setup Accounts</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('vendor_management','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-store"></i>
              <p>
                Vendor Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('createVendorView') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Vendor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('viewVendorList') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vendors List</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('purchase','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Purchase
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('purchaseEntryPage') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Entry</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('purchaseInventory') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Inventory</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('purchaseHistory') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase History</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('purchaseReturn') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Return</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('purchaseSetup') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Setup</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('payment','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-receipt"></i>
              <p>
                Payment
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('paymentPurchase') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payment Purchase</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('viewPaymentHistory') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payment History</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('ledger','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-sticky-note"></i>
              <p>
                Ledger
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('viewGeneralLedger') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General Ledger</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('viewSubsidiaryLedger') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Subsidiary Ledger</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('journal','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>
                Journal
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('journalVoucher') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Journal Voucher</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('listJournal') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Journal List</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('trial_balance','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
              <p>
                Trial Balance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('trialBalance') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Trial Balance</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('profit_and_loss','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
              <p>
                Profit And Loss
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('profitAndLoss') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Profit And Loss</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          
<!--       @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('balance_sheet','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
              <p>
               Trading Account
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('viewTradingAccount') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Trading Account</p>
                </a>
              </li>
            </ul>
          </li>
          @endif -->

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('balance_sheet','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
              <p>
               Balance Sheet
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('balanceSheet') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Balance Sheet</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(App\Models\UserPermission::where('user_role',Auth::user()->user_role)->where('petty_cash','on')->count() != null )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
              Petty Cash Payment
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ Route('pettyCashVoucher') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Petty Cash Payment</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('listPettyCash') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List PettyCash Payments</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if(Auth::user()->user_role==1)
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class=" nav-icon fas fa-cogs"></i>
              <p>
              System Setup
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ Route('setupAccount') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Payment Method</p>
                </a>
              </li>
              @if(App\Models\CompanyInformations::count()==0)
              <li class="nav-item">
                <a href="{{ Route('companyInformations') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Setup Company Details</p>
                </a>
              </li>
              @else
              <li class="nav-item">
                <a href="{{ Route('companyInformationsView') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Company Details</p>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a href="{{ Route('salarySetup') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Salary</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('salesRestaurantSetup') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Restaurant</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('purchaseSetup') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Tax</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('setupPettyCash') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Setup Petty Cash</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    @yield("page-content")
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2021-2022 <a href="http://teenets.com">teenets.com</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 2.0
    </div>
  </footer>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
@include('sweetalert::alert')
@livewireScripts
</body>
@yield('script')
</html>
