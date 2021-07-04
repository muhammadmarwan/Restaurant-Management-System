<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use charlieuki\ReceiptPrinter\ReceiptPrinter;
use charlieuki\ReportPrinter\ReportPrinter;
use Carbon\Carbon;
use App\Models\RestSale;
use App\Models\RestSaleItem;
use App\Models\DeliverySale;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Auth;
use App\Models\User;
use charlieuki\ReceiptPrinter\ReportItems as ReportItem;
use Illuminate\Support\Facades\DB;
use App\Models\CashDrawer;

class ReceiptController extends Controller
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

    public function printBill(Request $request)
    {   
        $getSale = RestSale::where('transaction_id',$request->saleId)->first();

        $items = RestSaleItem::where('sale_id',$request->saleId)
        ->select('product_name as name','quantity as qty','unit_price as price')
        ->get();

        $type = null;
        $address = null;
        $code = $getSale->bill_no;

        if($getSale->sale_type=='DELIVERY')
        {
            $type = 'Delivery';
            $address = DeliverySale::where('token_no',$getSale->bill_no)->first();
        }elseif($getSale->sale_type=='TAKE AWAY')
        {
            $type = 'Take Away';
        }else{
            $type = 'Dine In';
        }   

        for ($i=0; $i<1; $i++)
        {        
        // Set params
        $mid = '123123456';
        $store_name = 'ZEYAN LLC';
        $store_address = 'Busness Bay, Dubai ,United Arab Emirates';
        $store_phone = '0568382638, 0556565677, 099898979';
        $store_email = 'yourmart@email.com';
        $store_website = 'yourmart.com';
        $tax_percentage = 5;
        $transaction_id = 'TX123ABC456';
        // $currency = 'DH';

        $sum = 0;
        // Init printer
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );

        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);
        
        $printer->printReceiptType($type,$address,$code);

        // Set currency
        // $printer->setCurrency($currency);

        // Add items
        foreach ($items as $item) {
            $printer->addItem(
                $item['name'],
                $item['qty'],
                $item['price']
            );

            $sum += $item['price'] * $item['qty'];
        }
        $printer->calculateSubtotal($sum);
        // Set tax
        $printer->setTax($tax_percentage);
        // Calculate total
        $printer->calculateGrandTotal();
        // Set transaction ID
        $printer->setTransactionID($transaction_id);
        // Set qr code
        $printer->setQRcode([
            $transaction_id,
        ]);
        $printer->printReceipt();
        }

        return redirect()->back();
    }


    public function printReport(Request $request)
    {
        $name = Auth::user()->user_name;
        $first = RestSale::where('close_status',0)->value('created_at');
        $last = RestSale::where('close_status',0)->latest()->value('created_at');
        $now = Carbon::now();
        $dateTime = $now->toDateTimeString();

        if($first)
        {
            $firstSale = $first->toDateTimeString();
        }else{
            $firstSale=null;
        }
        if($last)
        {
            $lastSale = $last->toDateTimeString();
        }else{
            $lastSale=null;
        }

        //cash sale and card sale
        $cashSale = RestSale::where('close_status',0)->where('payment_method','cash')
        ->sum('total_amount');
        $cardSale = RestSale::where('close_status',0)->where('payment_method','card')
        ->sum('total_amount');

        $totalSale = $cashSale + $cardSale;

        $totalSale = number_format($totalSale,2);

        $cashSale = number_format($cashSale,2);
        $cardSale = number_format($cardSale,2);

        $dineInSale = RestSale::where('close_status',0)->where('sale_type','DINE IN')
        ->sum('total_amount');
        $takeAwaySale = RestSale::where('close_status',0)->where('sale_type','TAKE AWAY')
        ->sum('total_amount');
        $deliverySale = RestSale::where('close_status',0)->where('sale_type','DELIVERY')
        ->sum('total_amount');
        $dineInSale = number_format($dineInSale,2);
        $takeAwaySale = number_format($takeAwaySale,2);
        $deliverySale = number_format($deliverySale,2);


        //sale count
        $saleCount = RestSale::where('close_status',0)->count();

        $sale = RestSale::where('close_status',0)->get();

        $totalPercentage = 0;
        $totalRevenue = 0;
        foreach ($sale as $value) {
            if ($value->total_amount >= 5) {
                $total = $value->total_amount;

                $value->total_amount = number_format($value->total_amount,2);

                $percentage = (5 / 100) * $total;

                $value->percentage = $percentage;
                $value->percentage = number_format($value->percentage,2);

                $value->revenue = $total - $percentage;
                $value->revenue = number_format($value->revenue,2);

                $totalPercentage += $value->percentage;
                $totalRevenue += $value->revenue;

            } else {
                $value->percentage = 0;

                $value->revenue = $value->total_amount;

                $totalPercentage += $value->percentage;
                $totalRevenue += $value->revenue;
            }
        }  

        //Sale by user
        $saleByUser = User::leftjoin('rest_sales','users.user_id','rest_sales.auth_user')
        ->where('rest_sales.close_status',0)
        ->groupby('users.user_name')
        ->select('users.user_name',DB::raw('SUM(rest_sales.total_amount) AS total'))->get();

        //cash drawer 
        $drawer = CashDrawer::value('drawer_cash');

        $drawer = number_format($drawer,2);

        $items = RestSale::leftjoin('rest_sale_items','rest_sales.transaction_id','rest_sale_items.sale_id')
        ->where('rest_sales.close_status',0)
        ->select('rest_sale_items.product_name as name','rest_sale_items.quantity as qty','rest_sale_items.total_amount as price',
        'rest_sale_items.product_id')
        ->distinct()->get();

        foreach ($items as $item) {
            $count =  RestSale::leftjoin('rest_sale_items','rest_sales.transaction_id','rest_sale_items.sale_id')
            ->where('rest_sales.close_status',0)
            ->where('rest_sale_items.product_id',$item->product_id)
            ->count();
            
            if($count>1)
            {
                $sumquantity = RestSaleItem::leftjoin('rest_sales','rest_sales.transaction_id','rest_sale_items.sale_id')
                ->where('rest_sale_items.product_id',$item->product_id)
                ->where('rest_sales.close_status',0)
                ->sum('rest_sale_items.quantity');

                $sumprice = RestSaleItem::leftjoin('rest_sales','rest_sales.transaction_id','rest_sale_items.sale_id')
                ->where('rest_sale_items.product_id',$item->product_id)
                ->where('rest_sales.close_status',0)
                ->sum('rest_sale_items.total_amount');

                $this->addItem(
                    $item['name'],
                    $sumquantity,
                    $sumprice
                );
            }elseif($count==1){
                $this->addItem(
                    $item['name'],
                    $item['qty'],
                    $item['price']
                );
            }
        }
       
        $connector = new WindowsPrintConnector("smb://LAPTOP-LSIQVUUQ/SGT-88IV");
        $line = '';
        $line2 = '';

        $printer = new Printer($connector);
        $printer->initialize();
        $printer->selectPrintMode();        
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer->text("City Fresh");
        $printer->feed();
        $printer->selectPrintMode();
        $printer->text("Restaurant LLC");
        $printer->feed();
        $printer->text("Busness Bay, Dubai, United Arab Emirates");
        $printer->feed();
        $printer->text("Phone : 0568382638, 04249859100, 0989787908");
        $printer->feed();
        $printer->setBarcodeHeight(50);
        $printer->setBarcodeWidth(4);
        $printer->barcode("12345", Printer::BARCODE_CODE39);
        $printer->text('#12345');
        $printer->feed();
        $printer->setEmphasis(true);
        for ($i = 0; $i < 47; $i++) {
            $line .= '=';
            $line2 .= '-';
        }
        $printer->text($line);
        $printer->feed();
        $printer->text("Sales Report\n");
        $printer->text($line);
        $printer->setEmphasis(false);
        $printer->feed(2);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text('Printed By :' . $name);
        $printer->feed();
        $printer->text('Time       :' . $dateTime);
        $printer->feed(2);
        $printer->setEmphasis(true);
        $printer->text($line2);
        $printer->setEmphasis(false);        
        $printer->feed(2);
        $printer->text('First Sale  :' . $firstSale);
        $printer->feed();
        $printer->text('Last Sale   :' . $lastSale);
        $printer->feed(2);
        $printer->setEmphasis(true);
        $printer->text($line2);
        $printer->feed(2);

        $right_cols = 10;
        $left_cols = 5;
        $drawer1 = str_pad('Total Cash In Drawer', 36) ;
        $drawer2 = str_pad($drawer, $right_cols, ' ', STR_PAD_LEFT);
        $printer->text($drawer1.$drawer2);
        $printer->feed(2);
        $printer->text($line);
        $printer->setEmphasis(false);
        $printer->feed(2);

        $cash1 = str_pad('Cash Sale', 36) ;
        $cashSale1 = str_pad($cashSale, $right_cols, ' ', STR_PAD_LEFT);
        $printer->text($cash1.$cashSale1);

        $printer->feed();
        $card1 = str_pad('Card Sale', 36) ;
        $cardSale1 = str_pad($cardSale, $right_cols, ' ', STR_PAD_LEFT);
        $printer->text($card1.$cardSale1);
        $printer->feed(2);
        $printer->setEmphasis(true);
        $tot1 = str_pad('Total Sale', 36) ;
        $tot2 = str_pad($totalSale, $right_cols, ' ', STR_PAD_LEFT);
        $printer->text($tot1.$tot2);
        $printer->feed();
        $bill1 = str_pad('Total Bills', 36) ;
        $bill2 = str_pad($saleCount, $right_cols, ' ', STR_PAD_LEFT);
        $printer->text($bill1.$bill2);
        
        $printer->feed(2);
        $printer->text($line);
        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text('Sale Types');
        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text($line2);
        $printer->feed(2);
        $dine1 = str_pad('Dine In', 36) ;
        $dine2 = str_pad($dineInSale, $right_cols, ' ', STR_PAD_LEFT);
        $printer->text($dine1.$dine2);
        $printer->feed();
        $take1 = str_pad('Take Away', 36) ;
        $take2 = str_pad($takeAwaySale, $right_cols, ' ', STR_PAD_LEFT);
        $printer->text($take1.$take2);
        $printer->feed();
        $deli1 = str_pad('Delivery', 36) ;
        $deli2 = str_pad($deliverySale, $right_cols, ' ', STR_PAD_LEFT);
        $printer->text($deli1.$deli2);
        $printer->feed(2);
        $printer->text($line);
        $printer->feed();
        
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text('Sale By User');
        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text($line2);
        $printer->feed(2);
        foreach($saleByUser as $value)
        {
            $right_cols = 10;
            $left_cols = 5;
            $total = number_format($value->total,2);
            $print_name = str_pad($value->user_name, 40) ;
            $print_subtotal = str_pad($total, $right_cols, ' ', STR_PAD_LEFT);
            $printer->text($print_name.$total);    
            $printer->feed();   
        }
        $printer->feed();
        $printer->text($line);
        $printer->feed();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer->text('Items');
        $printer->feed();
        $printer->text($line2);
        $printer->feed();
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer->text('Item                          Qty        Total');
        $printer->feed();
        $printer->text($line2);
        $printer->setEmphasis(false);
        $printer->feed();
        foreach ($this->items as $item) {
            $printer->text($item);
        }
        $printer->feed();
        $printer->setEmphasis(true);
        $printer->text($line);
        $printer->feed(2);
        $right_cols = 10;
        $left_cols = 5;
        $percentage = str_pad('Vat 5%', 35) ;
        $percentageTot = str_pad($totalPercentage, $right_cols, ' ', STR_PAD_LEFT);
        $printer->text($percentage.$percentageTot);
        $printer->feed();
        $revenue = str_pad('Total Before Vat%', 35) ;
        $revenueTot = str_pad($totalRevenue, $right_cols, ' ', STR_PAD_LEFT);
        $printer->text($revenue.$revenueTot);
        $printer->feed(2);
        $printer->setEmphasis(true);
        $printer->text($line2);
        $printer->feed(2);
        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $right_cols = 10;
        $left_cols = 5;
        $todayTotal = str_pad('Todays Sale', 13.5) ;
        $todayTotal1 = str_pad($totalSale, $right_cols, ' ', STR_PAD_LEFT);
        $printer->text($todayTotal.$todayTotal1);
        $printer->feed(2);
        $printer->selectPrintMode();
        $printer->setEmphasis(true);
        $printer->text($line);
        $printer->feed(2);
        $printer->setEmphasis(false);
        // /* Cut the receipt and open the cash drawer */
        $printer->cut();
        // $printer->pulse();
        $printer->close();
        return redirect()->route('restaurantSaleClose');
    }

    public function addItem($name, $qty, $price) {
        $item = new ReportItem($name, $qty, $price);
        
        $this->items[] = $item;
    }

    public function cashUpdate(Request $request)
    {
        $update = CashDrawer::where('status',0)
        ->update(['drawer_cash'=>$request->cash]);
        return redirect()->back();
    }

    public function deleteSales(Request $request)
    {
        $delete = RestSale::where('transaction_id',$request->id)->delete();

        $deleteItems = RestSaleItem::where('sale_id',$request->id)->delete();

        return redirect()->back();
    }
}
