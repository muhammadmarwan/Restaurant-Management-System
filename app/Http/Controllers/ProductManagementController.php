<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ProductCategory;
use App\TransactionId\Transaction;
use App\Common\UserStatus;
use App\Models\Product;
use App\Common\BarcodeStatus;
use Illuminate\Support\Facades\DB;
use App\Models\ProductQuantityUnit;
use RealRashid\SweetAlert\Facades\Alert;

class ProductManagementController extends Controller
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

    public function productCategory()
    {
        $name = Auth::user()->user_name;
        $role = Auth::user()->user_role;
        return view('productCategory',['name'=>$name,'role'=>$role]);
    }

    public function createProduct()
    {
        $productCategory = ProductCategory::where('status',UserStatus::active)
                ->select('category_name as label','transaction_id as value')
                ->get();

        $quantityUnits = ProductQuantityUnit::all();         

        $name = Auth::user()->user_name;
        $role = Auth::user()->user_role;
        return view('createProduct',['name'=>$name,'role'=>$role,'category'=>$productCategory,'units'=>$quantityUnits]);
    }

    public function storeCategory(Request $request)
    {
        $this->validate(request(), [
            'category' => 'required',
            'code' => 'required',
            'slug' => 'required',
            'status' => 'required',
        ]);

        try {

            $productCategory = new ProductCategory();
            $productCategory->transaction_id =  Transaction::setTransactionId();
            $productCategory->category_name = $request->category;
            $productCategory->category_code = $request->code;
            $productCategory->slug = $request->slug;
            $productCategory->status = $request->status;
            $productCategory->save(); 

            return redirect('productCategory')->with('message', 'Product Category Registerd Successfully!');        
        }
            
        catch (Exception $e){

            return json_encode(array("status" => 300));
        }
    }
    public function storeProduct(Request $request)
    {
        $this->validate(request(), [
            'category' => 'required',
            'productName' => 'required',
            'productCode' => 'required',
            'quantityUnit' => 'required',
            'brand' => 'required',
        ]);

        try {
            $product = new Product();
            $product->transaction_id =  Transaction::setTransactionId();
            $product->product_category_code = $request->category;
            $product->product_name = $request->productName;
            $product->product_code = $request->productCode;
            $product->brand = $request->brand;
            $product->narration = $request->narration;
            if($request->barcode==null)
            {
                $product->barcode = mt_rand(1000000,9999999);
                $product->barcode_status = BarcodeStatus::notSelected;
            }else{
                $product->barcode = $request->barcode;
                $product->barcode_status = BarcodeStatus::selected;
            }
            $product->quantity_unit = $request->quantityUnit;
            $product->created_by = Auth::user()->transaction_id;    
            $product->save(); 
                
            Alert::success('Success','Products Added Successfully!');
            return redirect()->back();        
        }
            
        catch (Exception $e){

            return json_encode(array("status" => 300));
        }
    }

    public function productList()
    {
        $product = Product::leftjoin('product_categories','products.product_category_code','product_categories.transaction_id')
                    ->leftjoin('users','users.transaction_id','products.created_by')                  
                    ->select('products.*','product_categories.category_name','users.user_name as createdBy')
                    ->get();

        $productCategory = ProductCategory::where('status',UserStatus::active)
                    ->select('category_name as label','transaction_id as value')
                    ->get();

        $quantityUnits = ProductQuantityUnit::all();

        $userName = Auth::user()->user_name;
        $userRole = Auth::user()->user_role;

        return view('productList',['products'=>$product,'name'=>$userName,'role'=>$userRole,
        'category'=>$productCategory,'units'=>$quantityUnits]);
    }
    
    public function barcodeList()
    {
        $products = Product::all();
        $name = Auth::user()->user_name;

        return view('barcode.productBarcodes',['name'=>$name,'products'=>$products]);
    }

    public function productUpdate(Request $request)
    {
        $name = Auth::user()->user_name;
    
        $product = Product::leftjoin('product_categories','products.product_category_code','product_categories.transaction_id')
                    ->leftjoin('users','users.transaction_id','products.created_by')                  
                    ->select('products.*','product_categories.category_name','users.user_name as createdBy')
                    ->get();

        $update = Product::where('id',$request->user_id)->update(['product_name'=>$request->product,
        'product_code'=>$request->code,'brand'=>$request->brand,'quantity_unit'=>$request->unit]);

        Alert::success('Updated','Products Updated Successfully!');
        return redirect('productList');
    }

    public function deleteProduct(Request $request)
    {
        $product = Product::where('transaction_id',$request->productId)->delete();

        $productDelete = Product::leftjoin('product_categories','products.product_category_code','product_categories.transaction_id')
                    ->leftjoin('users','users.transaction_id','products.created_by')                  
                    ->select('products.*','product_categories.category_name','users.user_name as createdBy')
                    ->get();
                    
        Alert::success('Deleted','Product Deleted Successfully!');
        return redirect('productList');
    }

}
