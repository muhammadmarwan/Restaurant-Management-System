<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\TransactionId\Transaction;
use Auth;
use App\Models\Country;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Carbon\Carbon;
use App\Models\Items;
use RealRashid\SweetAlert\Facades\Alert;
use charlieuki\ReceiptPrinter\ReceiptPrinter;
use App\Models\RestSale;
use App\Models\RestSaleItem;

class VendorController extends Controller
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

    public function vendorRegistration()
    {
        $userName = Auth::user()->user_name;

        $country = Country::all();

        return view('vendorRegistration', ['name' => $userName, 'country' => $country]);
    }

    public function storeVendorDetails(Request $request)
    {
        $this->validate($request, [
            'vendorName' => 'required',
            'vendorId' => 'required',
            'emailId' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'required',
            'country' => 'required',


        ]);

        try {
            $vendor = new Vendor();
            $vendor->transaction_id = Transaction::setTransactionId();
            $vendor->name = $request->vendorName;
            $vendor->vendor_id = $request->vendorId;
            $vendor->email_id = $request->emailId;
            $vendor->phone = $request->phone;
            $vendor->address = $request->address;
            $vendor->country = $request->country;
            $vendor->save();

            \Illuminate\Support\Facades\DB::table('sub_accounts')->insert([
                [
                    'transaction_id' => Transaction::setTransactionId(),
                    'account_name' => $vendor->name,
                    'parent_account_id' => 1004,
                    'account_code' => $vendor->transaction_id,
                    'degree' => 2,
                    'balance_amount' => 0,
                ]
            ]);
            Alert::success('Success', 'Vendor Created Successfully');
            return redirect('viewVendor')->with('message');
        } catch (Exception $e) {
            return json_encode(array("status" => 300));
        }
    }

    public function viewVendorList()
    {
        $name = Auth::user()->user_name;
        $vendor = Vendor::all();
        $country = Country::all();

        return view('vendorList', ['name' => $name, 'vendor' => $vendor, 'country' => $country]);
    }

    public function vendorUpdate(Request $request)
    {
        if (
            $request->vendorName != null && $request->vendorCode != null && $request->phone != null
            && $request->emailId != null && $request->country != null
        ) {
            $vendor = Vendor::where('id', $request->vendorId)
                ->update([
                    'name' => $request->vendorName, 'vendor_id' => $request->vendorCode, 'email_id' => $request->emailId,
                    'phone' => $request->phone, 'country' => $request->country
                ]);

            Alert::success('Updated', 'Vendor Updated Successfully');
            return redirect()->back();
        } else {
            return redirect()->back();

            Alert::error('error', 'Please fill all fields');
        }
    }
    public function demoTestPage()
    {
        $getSale = RestSale::first();

        $items = RestSaleItem::select('product_name as name','quantity as qty','unit_price as price')
        ->get();

        $type = null;
        $address = null;
        $code = $getSale->bill_no;

        if($getSale->sale_type=='DELIVERY')
        {
            $type = 'Delivery';
            $address = DeliverySale::where('token_no',$getSale->bill_no)->first();
        }
        elseif($getSale->sale_type=='TAKE AWAY')
        {
            $type = 'Take Away';
        }else{
            $type = 'Dine In';
        }   
           
        // for ($i=0; $i<1; $i++)
        // {
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

        // //server connect printer
        // $ip=$_SERVER['REMOTE_ADDR']; 
        // $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); 
        // /*if you use ipaddress */ 
        // $connector = new WindowsPrintConnector("smb://$ip/EPSON80");
        //  /*if you use hostname */ 
        // $connector = new WindowsPrintConnector("smb://$hostname/EPSON80");

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
        // }

        // return redirect()->back();        
    }
}
