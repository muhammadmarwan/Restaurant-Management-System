<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Items;
use App\Models\ItemSetup;
use App\TransactionId\Transaction;
use RealRashid\SweetAlert\Facades\Alert;

class ItemsController extends Controller
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

    public function listItems()
    {
        $name = Auth::user()->user_name;

        $items = Items::all();

        return view('items.listItems',['name'=>$name,'items'=>$items]);
    }

    public function storeItems(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'itemCode' => 'required',
            'amount' => 'required',
            'description' => 'required',
        ]);

        $items = new Items();
        $items->transaction_id = Transaction::setTransactionId();
        $items->item_name = $request->name;
        $items->item_code = $request->itemCode;
        $items->amount = $request->amount;
        $items->description = $request->description;
        $items->save();

        Alert::success('Success','Item added successfully');
        return redirect()->back();
    }

    public function updateItems(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'itemCode' => 'required',
            'amount' => 'required',
            'description' => 'required',
        ]);

        $update = Items::where('id',$request->itemId)
        ->update(['item_name'=>$request->name,'item_code'=>$request->itemCode,
        'description'=>$request->description,'amount'=>$request->amount]);

        Alert::success('Updated','Item Updated successfully');
        return redirect()->back();
    }

    public function deleteItems(Request $request)
    {
        $delete = Items::where('id',$request->itemId)->delete();
        
        Alert::success('Deleted','Item Deleted successfully');
        return redirect()->back();
    }

    public function setupItems(Request $request)
    {
        $name = Auth::user()->user_name;

        $normal = ItemSetup::leftjoin('items','items.transaction_id','item_setups.item_id')
        ->where('category',1)->select('item_setups.id as itemId','item_setups.*','items.*')
        ->orderBy('item_setups.id')
        ->get();

        $main = ItemSetup::leftjoin('items','items.transaction_id','item_setups.item_id')
        ->where('category',2)->select('item_setups.id as itemId','item_setups.*','items.*')
        ->orderBy('item_setups.id')
        ->get();

        $extra = ItemSetup::leftjoin('items','items.transaction_id','item_setups.item_id')
        ->where('category',3)->select('item_setups.id as itemId','item_setups.*','items.*')
        ->orderBy('item_setups.id')
        ->get();

        $items = Items::all();

        return view('items.setupItems',['name'=>$name,'normal'=>$normal,'main'=>$main,'extra'=>$extra,
        'items'=>$items]);
    }

    public function setupItemsStore(Request $request)
    {
        if(!isset($request->item))
        {
            return redirect()->back();
        }
        $item = Items::where('transaction_id',$request->item)->first();

        $update = ItemSetup::where('id',$request->modelId)
        ->update(['item_name'=>$item->item_name,'item_code'=>$item->item_code,'item_id'=>$request->item]);

        toast('Success Toast','success');
        return redirect()->back();
    }
}
