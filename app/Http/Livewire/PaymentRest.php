<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\RestSale;
use Illuminate\Support\Facades\DB;
use App\Models\CashDrawer;
use App\Models\TakeAwaySale;
use App\Models\TakeAwayItems;
use App\Models\DeliverySaleItems;
use App\Models\DeliverySale;

class PaymentRest extends Component
{
    public $billCode,$billAmount,$amount,$discount;
    public $payAmount,$returnAmount,$payStatus;
    public $saleDataList,$cashAmount;

    public function mount()
    {
        $this->saleDataList = RestSale::where('payment_status',0)
        ->select(DB::raw("CONCAT(bill_no,' (',sale_type,') ',' - ',total_amount,' DH') AS data"),'bill_no')
        ->get();

        $this->cashAmount = CashDrawer::value('drawer_cash');
        $this->cashAmount = number_format($this->cashAmount,2);

    }

    public function render()
    {
        if($this->discount==null)
        {
            $this->billAmount = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->value('total_amount');
        }
        
        $paymentStatusCheck = RestSale::where('barcode',$this->billCode)
        ->orWhere('bill_no',$this->billCode)
        ->value('payment_status');
        
            if($paymentStatusCheck==1)
            {
                $this->payStatus = 'BILL PAID';
            }
            else{
                $this->payStatus = null;
            }

        $this->saleDataList = RestSale::where('payment_status',0)
        ->select(DB::raw("CONCAT(bill_no,' (',sale_type,') ',' - ',total_amount,' DH') AS data"),'bill_no','sale_type','table_no')
        ->get();

        return view('livewire.payment-rest');
    }

    public function CheckBillCode()
    {        
        
    }

    public function submit()
    {
        dd($this->amount);
    }

    public function keyBoard($id)
    {
        if($id==90)
        {
            $update = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->update(['paid_amount'=>null]);

            $result = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->value('paid_amount');

            $this->payAmount = $result;
            $this->returnAmount = $result - $this->billAmount;

        }
        else{
            $getPayAmount = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->value('paid_amount');

            $total = $getPayAmount.$id;
            // dd($total);

            $updatePayAmount = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->update(['paid_amount'=>$total]);

            $result = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->value('paid_amount');

            $this->payAmount = $result;

            $this->returnAmount = $result - $this->billAmount;

            $updateReturn = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->update(['return_cash'=>$this->returnAmount]);

        }
    }

    public function paymentMethod($method)
    {
        $this->method = $method;
        $updateMethod = RestSale::where('barcode',$this->billCode)
        ->orWhere('bill_no',$this->billCode)
        ->update(['payment_method'=>$method]);
    }

    public function payBill()
    {
        $updateBill = RestSale::where('barcode',$this->billCode)
        ->orWhere('bill_no',$this->billCode)
        ->update(['payment_status'=>1]);

        $method = RestSale::where('barcode',$this->billCode)
        ->orWhere('bill_no',$this->billCode)
        ->value('payment_method');

        $saleType = RestSale::where('barcode',$this->billCode)
        ->orWhere('bill_no',$this->billCode)
        ->value('sale_type');

        if($saleType=='TAKE AWAY')
        {
            $delete = TakeAwaySale::where('token_no',$this->billCode)->delete();

            $deleteItems = TakeAwayItems::where('token_no',$this->billCode)->delete();
        }elseif($saleType=='DELIVERY')
        {
            $delete = DeliverySale::where('token_no',$this->billCode)->delete();

            $deleteItems = DeliverySaleItems::where('token_no',$this->billCode)->delete();
        }

        if($method=='cash')
        {
            //update drawer cash
            $pay = $this->payAmount;
            $return = $this->returnAmount;
            $balance = $pay - $return;
            $update = CashDrawer::increment('drawer_cash',$balance);
        
            //when discount clicked
            $total = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->value('total_amount');
        }

        $discount = RestSale::where('barcode',$this->billCode)
        ->orWhere('bill_no',$this->billCode)
        ->value('discount');

        if($discount!=0)
        {
            //update total price
            $price = ($discount / 100) * $total;

            $newPrice = $total-$price;

            $discount = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->update(['total_amount'=>$newPrice]);
        }

        $this->billCode='';

        return redirect()->route('drawerOpen');
    }

    public function discount($id)
    {
        $discountCount = RestSale::where('bill_no',$this->billCode)
        ->value('discount');

        if($discountCount==$id)
        {
            $discountUpdate = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->update(['discount'=>0]);

            $this->discount = 0;

            $totalPrice = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->value('total_amount');

            $this->billAmount = $totalPrice;

            $this->returnAmount = $this->payAmount - $this->billAmount;
            
        }else{
            $discountUpdate = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->update(['discount'=>$id]);

            $this->discount = $id;

            $totalPrice = RestSale::where('barcode',$this->billCode)
            ->orWhere('bill_no',$this->billCode)
            ->value('total_amount');

            $percentage = $id;

            $newPrice = ($percentage / 100) * $totalPrice;

            $this->billAmount = $totalPrice-$newPrice;

            $this->returnAmount = $this->payAmount - $this->billAmount;
        }        
    }
}
