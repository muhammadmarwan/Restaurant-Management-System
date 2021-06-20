<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\SalesCart;
use App\Models\Order as Orders;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Common\SaleCloseStatus;

class Order extends Component
{
    public $orders, $products=[],$product_code,$message='',$productInCart,$product_name,$count,$rowCount;

    public $pay_money='',$balance='',$bill_no='',$disc='',$todaySales=[],$SalesReturn,$closeSale;

    public $totalAmount,$grandTotal;

    public function mount()
    {
        $this->products = Product::all();
        $this->productInCart = SalesCart::all();

        $this->todaySales = Orders::leftjoin('order_transactions','order_transactions.order_id','orders.id')
        ->whereDay('orders.created_at', now()->day)
        ->select(DB::raw('DATE_FORMAT(orders.created_at, "%H:%i:%s") as time'),'orders.name','order_transactions.paid_amount',
        'order_transactions.balance','order_transactions.payment_method')
        ->get();

        $this->closeSale = Orders::leftjoin('order_transactions','order_transactions.order_id','orders.id')
        ->leftjoin('order_details','order_details.order_id','orders.id')
        ->where('orders.close_status',SaleCloseStatus::pending)
        ->sum('order_details.amount');

        $this->grandTotal = SalesCart::where('return_status',null)->sum('price_total');
    }

    public function InsertoCart()
    {
        $countProduct = Product::where('barcode', $this->product_code)
        ->orWhere('product_name',$this->product_name)
        ->first();

        if(!$countProduct){
            return ;
        } 

        $countCartProduct = SalesCart::where('return_status','null')
        ->orWhere('product_id',$this->product_code)
        ->orWhere('product_name',$this->product_name)
        ->count();

        if($countCartProduct > 0){

            $update = SalesCart::where('product_id',$countProduct->barcode)->first();
            $update->increment('product_qty',1);

            $this->count = $update->product_qty;
            $this->rowCount = $update->id;

            $updatePrice = $this->count * $update->product_price;
        
            $totalUpdate = SalesCart::where('product_id',$countProduct->barcode)->first();
            $totalUpdate->update(['price_total'=>$updatePrice]);

            $this->totalAmount = $updatePrice;

            $this->product_code = '';
            $this->product_name = '';

            $this->productInCart = $this->productInCart;

            $grandTotal = SalesCart::where('return_status',null)
            ->sum('price_total');

            $this->grandTotal = $grandTotal;

            return '';
        }

        $addToCart = new SalesCart;
        $addToCart->product_id = $countProduct->barcode;
        $addToCart->product_name = $countProduct->product_name;
        $addToCart->product_qty = 1;
        $addToCart->product_price = $countProduct->selling_price;
        $addToCart->price_total = $countProduct->selling_price * 1;
        $addToCart->user_id = Auth::user()->transaction_id;
        $addToCart->save();
 
        $this->productInCart->prepend($addToCart);
        $this->grandTotal = SalesCart::where('return_status',null)->sum('price_total');
        $this->product_code = '';
        $this->product_name = '';
        return ;
    }

    public function removeProductCart($cartId)
    {
        $deleteCart = SalesCart::find($cartId);
        $deleteCart->delete();

        $this->grandTotal = SalesCart::where('return_status',null)->sum('price_total');

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
        
        $this->totalAmount = $updatePrice;

        SalesCart::find($cartId)->update(['price_total'=>$updatePrice]);

        $grandTotal = SalesCart::where('return_status',null)
        ->sum('price_total');

        $this->grandTotal = $grandTotal;
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

        $this->totalAmount = $updatePrice;

        SalesCart::find($cartId)->update(['price_total'=>$updatePrice]);

        $grandTotal = SalesCart::where('return_status',null)
        ->sum('price_total');

        $this->grandTotal = $grandTotal;
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
        return view('livewire.order');
    }

    public function ReturnOrder()
    {
        return redirect()->to('/salesReturn');
        // $checkBillBarcode = Order::where('transaction_id',$orderId)->count();
    }    
}
