<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Country;
use Carbon\Carbon;
use App\TransactionId\Transaction;
use App\Models\CompanyInformations;
use RealRashid\SweetAlert\Facades\Alert;

class CompanyInformationsController extends Controller
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

    public function viewCompanyInformations()
    {
        $name = Auth::user()->user_name;

        $country = Country::all();

        $today = Carbon::today()->format('d-F-Y');

        return view('companyDetails.companySetup',['name'=>$name,'country'=>$country,'today'=>$today]);
    }
    
    public function storeCompanyDetials(Request $request)
    {
        $this->validate(request(), [
            'companyName' => 'required',
            'address' => 'required',
            'country' => 'required',
            'emailId' => 'required',
            'totalEmployees' => 'required',
            'phone1' => 'required',
        ]);

        $companyDetails = new CompanyInformations();
        $companyDetails->transaction_id = Transaction::setTransactionId();
        $companyDetails->company_name = $request->companyName;
        $companyDetails->company_address = $request->address;
        $companyDetails->country = $request->country;
        $companyDetails->email_id = $request->emailId;
        $companyDetails->total_employees = $request->totalEmployees;
        $companyDetails->phone = $request->phone1;
        $companyDetails->phone2 = $request->phone2;
        $companyDetails->phone3 = $request->phone3;
        $companyDetails->save();

        Alert::success('Success', 'Company Informations Added Successfully');

        return redirect('companyInformationsView');
    }
    public function companyInformationsView()
    {
        $name = Auth::user()->user_name;

        $companyInformation = companyInformations::first();

        return view('companyDetails.companyView',['name'=>$name,'company'=>$companyInformation]);
    }

    public function editCompanyDetails()
    {
        $name = Auth::user()->user_name;

        $company = companyInformations::first();

        $country = Country::all();

        $today = Carbon::today()->format('d-F-Y');

        return view('companyDetails.editCompanyDetails',['name'=>$name,'country'=>$country,
        'company'=>$company,'today'=>$today]);
    }

    public function updateCompanyDetails(Request $request)
    {
        $this->validate(request(), [
            'companyName' => 'required',
            'address' => 'required',
            'country' => 'required',
            'emailId' => 'required',
            'totalEmployees' => 'required',
            'phone1' => 'required',
        ]);

        $companyDetails = CompanyInformations::find(1);
        $companyDetails->transaction_id = Transaction::setTransactionId();
        $companyDetails->company_name = $request->companyName;
        $companyDetails->company_address = $request->address;
        $companyDetails->country = $request->country;
        $companyDetails->email_id = $request->emailId;
        $companyDetails->total_employees = $request->totalEmployees;
        $companyDetails->phone = $request->phone1;
        $companyDetails->phone2 = $request->phone2;
        $companyDetails->phone3 = $request->phone3;
        $companyDetails->save();

        Alert::success('Updated', 'Company Informations Updated Successfully');

        return redirect('companyInformationsView');
        
    }
}