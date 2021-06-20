<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\SalesCart;
use App\Models\Order;

class Sale extends Component
{
    public $products=[],$productInCart=[],$customerDetails;

    public $message,$bill_code,$addToCart,$cartCount;

    public function mount()
    {
        $this->products = Product::all();
        $this->productInCart = SalesCart::where('return_status','1')->get();
        $this->cartCount = SalesCart::where('return_status','1')->count();
        $this->customerDetails = SalesCart::leftjoin('orders','orders.barcode','sales_carts.bill_id')
        ->leftjoin('order_transactions','order_transactions.order_id','orders.id')
        ->where('sales_carts.return_status','1')
        ->select('orders.*','order_transactions.*')
        ->first();
    }

    public function render()
    {
        return view('livewire.sale');
    }

    public function ListBill()
    {
        $order = Order::leftjoin('order_details','order_details.order_id','orders.id')
        ->leftjoin('order_transactions','order_transactions.order_id','orders.id')
        ->leftjoin('products','products.barcode','order_details.product_id')
        ->where('orders.barcode',$this->bill_code)
        ->select('order_details.*','products.product_name','products.price as productPrice','order_transactions.user_id',
        'products.barcode as productBarcode')
        ->get();

        $this->customerDetails = SalesCart::leftjoin('orders','orders.barcode','sales_carts.bill_id')
        ->leftjoin('order_transactions','order_transactions.order_id','orders.id')
        ->where('sales_carts.return_status','1')
        ->select('orders.*','order_transactions.*')
        ->first();

        if(!$order){
            return ;
        } 

        foreach($order as $value)
        {
            $addToCart = new SalesCart;
            $addToCart->product_id = $value->productBarcode;
            $addToCart->product_name = $value->product_name;
            $addToCart->product_qty = $value->quantity;
            $addToCart->product_price = $value->productPrice;
            $addToCart->price_total = $value->amount;
            $addToCart->user_id = $value->user_id;
            $addToCart->bill_id = $this->bill_code;
            $addToCart->return_status = 1;
            $addToCart->save();

            $this->productInCart->prepend($addToCart);
        }

        $this->cartCount = SalesCart::where('return_status','1')->count();

        $this->bill_code = '';
        return ;
    }

    public function removeProduct($cartId)
    {
        $deleteCart = SalesCart::find($cartId);
        $deleteCart->delete();

        $this->productInCart = $this->productInCart->except($cartId);
    }

    public function IncrementQty($cartId)
    {
        $carts = SalesCart::find($cartId);
        $carts->increment('product_qty',1);
        $updatePrice = $carts->product_qty * $carts->product_price;
        
        SalesCart::find($cartId)->update(['price_total'=>$updatePrice]);

        $this->customerDetails = SalesCart::leftjoin('orders','orders.barcode','sales_carts.bill_id')
        ->leftjoin('order_transactions','order_transactions.order_id','orders.id')
        ->where('sales_carts.return_status','1')
        ->select('orders.*','order_transactions.*')
        ->first();
    }

    public function DecrementQty($cartId)
    {
        $this->customerDetails = SalesCart::leftjoin('orders','orders.barcode','sales_carts.bill_id')
        ->leftjoin('order_transactions','order_transactions.order_id','orders.id')
        ->where('sales_carts.return_status','1')
        ->select('orders.*','order_transactions.*')
        ->first();

        $carts = SalesCart::find($cartId);
        if($carts->product_qty ==1)
        {
            return session()->flash('info',' Product '.$carts->product_name.'Quantity can not be less than 1, add quantity or remove product in cart.');
        }
        $carts->decrement('product_qty',1);
        $updatePrice = $carts->product_qty * $carts->product_price;
        
        SalesCart::find($cartId)->update(['price_total'=>$updatePrice]);

        $this->customerDetails = SalesCart::leftjoin('orders','orders.barcode','sales_carts.bill_id')
        ->leftjoin('order_transactions','order_transactions.order_id','orders.id')
        ->where('sales_carts.return_status','1')
        ->select('orders.*','order_transactions.*')
        ->first();

    }   
}
