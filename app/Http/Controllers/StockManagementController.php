<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class StockManagementController extends Controller
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

    public function stockDetails()
    {
        $stockDetails = Product::leftjoin('product_categories','product_categories.transaction_id','products.product_category_code')
        ->where('products.status',0)
        ->select(DB::raw("CONCAT(products.product_name,'(',products.quantity_unit,')') AS product"),'products.product_code',
        'products.stock','products.id','products.quantity_unit','product_categories.category_name')
        ->get();

        $name = Auth::user()->user_name;
        return view('stock.stockDetails',['name'=>$name,'stockDetails'=>$stockDetails]);
    }

    public function priceUpdate(Request $request)
    {
        $update = Product::where('id',$request->id)->update(['selling_price'=>$request->price]);

        return redirect()->back();
    }

    public function updateStock(Request $request)
    {
        // $formatted_value = $this->currency . number_format($value, 2, '.', '.');
        $updateStock = Product::where('id',$request->id)
        ->update(['stock'=>$request->stock]);

        Alert::success('Success', 'Stock Updated Successfully');
        return redirect()->back();
    }
}