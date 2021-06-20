<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use charlieuki\ReceiptPrinter\ReceiptPrinter;
use App\Models\RestSale;
use App\Models\RestSaleItem;
use App\Models\DeliverySale;

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
}
