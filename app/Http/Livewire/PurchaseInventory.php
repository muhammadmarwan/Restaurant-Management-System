<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\SalesCart;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseInventoryCart;
use App\TransactionId\Transaction;
use App\Models\SubAccounts;
use App\Models\Vendor;
use App\Common\AccountType;

class PurchaseInventory extends Component
{
    public $vendor=[],$accounts=[],$product_name,$product_code;
    public $products=[],$productInCart=[],$unitPrice,$purchaseId;

    public function mount()
    {
        $this->products = Product::all();
        $this->productInCart = PurchaseInventoryCart::all(); 
        $this->vendor = Vendor::where('status',0)->select('name as label','transaction_id as value')->get();
        $this->accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->get(); 
        
        // dd($this->productInCart);
    }

    public function render()
    {
        return view('livewire.purchase-inventory');
    }

    public function InsertoCart()
    {
        $countCartAvailable = PurchaseInventoryCart::leftjoin('products','products.transaction_id','purchase_inventory_carts.product_id')
        ->where('products.barcode',$this->product_code)
        ->orWhere('products.product_name',$this->product_name)
        ->count();

        if($countCartAvailable==0)
        {
        $countProduct = Product::where('barcode', $this->product_code)
        ->orWhere('product_name',$this->product_name)
        ->select('products.*',DB::raw("CONCAT(products.product_name,'-',products.quantity,'-',products.quantity_unit) AS product_name"))
        ->first();
        
        if(!$countProduct){
            return ;
        } 

        $cartStore = new PurchaseInventoryCart();
        $cartStore->transaction_id = Transaction::setTransactionId();
        $cartStore->product_id = $countProduct->transaction_id;
        $cartStore->product_name = $countProduct->product_name;
        $cartStore->unit_price = 0;
        $cartStore->quantity = 1;
        $cartStore->save();

        $this->products = Product::all();
        $this->vendor = Vendor::where('status',0)->select('name as label','transaction_id as value')->get();
        $this->accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->get();

        $this->productInCart->prepend($cartStore);

        $this->product_code = '';
        $this->product_name = '';
        return ;
        }
        else{
            $productQuantity = PurchaseInventoryCart::leftjoin('products','products.transaction_id','purchase_inventory_carts.product_id')
            ->where('products.barcode',$this->product_code)
            ->orWhere('products.product_name',$this->product_name)
            ->value('purchase_inventory_carts.quantity');

            $updateCart = PurchaseInventoryCart::leftjoin('products','products.transaction_id','purchase_inventory_carts.product_id')
            ->where('products.barcode',$this->product_code)
            ->orWhere('products.product_name',$this->product_name)
            ->update(['purchase_inventory_carts.quantity'=>$productQuantity + 1]);

            $this->products = Product::all();
            $this->productInCart = PurchaseInventoryCart::all(); 
            $this->vendor = Vendor::where('status',0)->select('name as label','transaction_id as value')->get();
            $this->accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
            ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
            ->where('degree',AccountType::Normal)
            ->get();
            
            $this->product_code = '';
            $this->product_name = '';
            return ;
        
        }
    }

    public function removeProductCart($cartId)
    {
        $deleteCart = PurchaseInventoryCart::find($cartId);
        $deleteCart->delete();

        $this->vendor = Vendor::where('status',0)->select('name as label','transaction_id as value')->get();
        $this->accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->get();

        $this->productInCart = $this->productInCart->except($cartId);

    }

    public function UpdatePrice($cart)
    {
        $updateCart = PurchaseInventoryCart::where('id',$cart)
        ->update(['purchase_inventory_carts.unit_price'=>$this->unitPrice]);

        $this->productInCart = PurchaseInventoryCart::all();

        $this->vendor = Vendor::where('status',0)->select('name as label','transaction_id as value')->get();
        $this->accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
            ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
            ->where('degree',AccountType::Normal)
            ->get();

        return ;    
    }
}
