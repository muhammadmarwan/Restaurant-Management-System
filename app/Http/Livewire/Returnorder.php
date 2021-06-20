<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\SalesCart;
use App\Models\Order;
use App\Models\OrderTransactions;
use Auth;
use Illuminate\Support\Facades\DB;

class Returnorder extends Component
{
    public $orders, $products=[],$product_code,$message='',$productInCart,$product_name;

    public $pay_money='',$balance='',$bill_no='',$disc='',$todaySales=[],$SalesReturn,$customers;

    public $bill_code,$cartCount,$orderDetails,$rowCount,$count;

    public function mount()
    {
        $this->products = Product::all();
        $this->productInCart = SalesCart::all();
        $this->cartCount = SalesCart::where('return_status','1')->count();

        $orders = SalesCart::first();
        if(isset($orders))
        $this->customers = Order::where('barcode',$orders->bill_id)->first();
        if(isset($this->customers))
        $this->orderDetails = OrderTransactions::where('order_id',$this->customers->id)->first();

    }
    public function InsertoCart()
    {
        $orders = SalesCart::first();
        if(isset($orders))
        $this->customers = Order::where('barcode',$orders->bill_id)->first();
        if(isset($this->customers))
        $this->orderDetails = OrderTransactions::where('order_id',$this->customers->id)->first();
        
        $order = Order::leftjoin('order_details','order_details.order_id','orders.id')
        ->leftjoin('order_transactions','order_transactions.order_id','orders.id')
        ->leftjoin('products','products.barcode','order_details.product_id')
        ->where('orders.barcode',$this->bill_code)
        ->select('order_details.*','products.product_name','products.selling_price as productPrice','order_transactions.user_id',
        'products.barcode as productBarcode')
        ->get();

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

    public function removeProductCart($cartId)
    {
        $deleteCart = SalesCart::find($cartId);
        $deleteCart->delete();

        $this->productInCart = $this->productInCart->except($cartId);

    }

    public function DiscountCalculate($id)
    {
        $carts = SalesCart::find($id);

        $total = $carts->value('price_total');

        $disc = $this->disc;

        if(!$disc)
        {
            $disc=0;
        }

        $percentage = $total / 100;
        $data =  $percentage * $disc;
        $result = $total - $data;
        
        SalesCart::find($id)->update(['price_total'=>$result]); 
        return view('livewire.order');
    }
    public function IncrementQty($cartId)
    {
        $carts = SalesCart::find($cartId);
        
        $carts->increment('product_qty',1);
        
        $this->productInCart = $this->productInCart;

        $this->count = $carts->product_qty;
        $this->rowCount = $cartId;

        $updatePrice = $carts->product_qty * $carts->product_price;
        
        SalesCart::find($cartId)->update(['price_total'=>$updatePrice]);
    }

    public function DecrementQty($cartId)
    {
        $carts = SalesCart::find($cartId);
        if($carts->product_qty ==1)
        {
            return session()->flash('info',' Product '.$carts->product_name.' Quantity can not be less than 1.');
        }

        $carts->decrement('product_qty',1);
        $this->count = $carts->product_qty;
        $this->rowCount = $cartId;
        
        $updatePrice = $carts->product_qty * $carts->product_price;
        
        SalesCart::find($cartId)->update(['price_total'=>$updatePrice]);
    }

    public function render()
    {
        $pay = $this->pay_money;
        if(!$pay)
        {
            $pay=0;
        }
        $totalAmount =  $pay - $this->productInCart->sum('price_total');
        $this->balance = $totalAmount;
        return view('livewire.returnorder');
    }

    public function ReturnOrder()
    {
        return redirect()->to('/salesReturn');
        $checkBillBarcode = Order::where('transaction_id',$orderId)->count();
    }
    public function ClearCart()
    {
        $deleteCart = SalesCart::truncate();


        $this->productInCart = $this->productInCart;

    }
}
