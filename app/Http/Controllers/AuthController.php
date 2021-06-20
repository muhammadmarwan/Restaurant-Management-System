<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Models\UserOtpCheck;
use Illuminate\Support\Facades\DB;
use App\Models\RestSale;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\TransactionDetails;
use App\Models\PettyCashSetup;

class AuthController extends Controller
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

    public function loginPage()
    {
        return view('loginPage');
    }

    public function checkLogin(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required',
            'password' =>  'required'
        ]);

        $userData = array(
            'user_id' => $request->userId,
            'password' => $request->password
        );

        if(Auth::attempt($userData))
        {
            return redirect('index');
        }else{
            // return back()->with('error', 'Wrong Login Details');
            return redirect()->route('login')->with('message', 'The User Id Or Password Is Incorrect'); 
        }
    }
    public function viewDashboard()
    {
        $userName = Auth::user()->user_name;

        $pettyAccount = PettyCashSetup::value('account_id');

        $pettyCashDebit = TransactionDetails::where('debit_account',$pettyAccount)
        ->sum('amount');

        $pettyCashCredit = TransactionDetails::where('credit_account',$pettyAccount)
        ->sum('amount');
    
        $pettyCash = $pettyCashDebit - $pettyCashCredit;

        $todaysSale = RestSale::whereDate('created_at', Carbon::today())
        ->where('payment_status',1)
        ->sum('total_amount');

        $debts = RestSale::where('payment_status',0)
        ->sum('total_amount');

        //available total cash is petty cash account + sale cash accounts

        $employees = Employee::where('status',0)->count();

        $sales = RestSale::select(DB::raw("SUM(total_amount) as sum"))
                    ->whereYear('created_at',date('Y')) 
                    ->groupBy(DB::raw("Month(created_at)"))
                    ->pluck('sum');         

        $month = RestSale::select(DB::raw("Month(created_at) as month"))
                    ->whereYear('created_at',date('Y'))
                    ->groupBy(DB::raw("Month(created_at)"))
                    ->pluck('month');            

        $datas = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($month as $index=> $months)  
        {
            $datas[$months-1] = $sales[$index];
        }  

        $today = Carbon::today()->format('d-F-Y');

        if(Auth::check()){

            if(Auth::user()->user_role==3)
            {
                return redirect('salesRestaurant');
            }elseif(Auth::user()->user_role==4)
            {
                return redirect('viewKitchenMenu');
            }

            return view('welcome',['name'=>$userName,'datas' => $datas,'today'=>$today,
            'todaysSale'=>$todaysSale,'debts'=>$debts,'employees'=>$employees,'pettyCash'=>$pettyCash]);
        }
    }
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
    public function viewChangePassword(Request $request)
    {
        $name = Auth::user()->user_name;
        $role = Auth::user()->user_role;

        return view('passwordChange',['name'=>$name,'role'=>$role]);

    }
    public function changePassword(Request $request)
    {
        if($request->password==$request->confirm_password)
        {
            $update = User::where('transaction_id',Auth::user()->transaction_id)
                    ->update(['password'=>bcrypt($request->password)]);

            return redirect()->route('dashboard')->with('message', 'Password Changed Successfully'); 

        }else{

            return redirect()->route('passChangeView')->with('message', 'The Password You Enterd Do Not Match'); 
        }   
    }

    public function forgetPassword(Request $request)
    {
        return view('forgetPassword');
    }

    public function forgetPasswordCheck(Request $request)
    {
        
        $fourRandomDigit = mt_rand(1000,9999);
  
        $toMail = $request->email_id;

        $user = User::where('email_id',$toMail)->first();
        $user_id = $user->transaction_id;

        //store otp
        $userOtp = new UserOtpCheck();
        $userOtp->user_id = $user->transaction_id;
        $userOtp->otp = $fourRandomDigit;
        $userOtp->save();
        /////////////////

            if($user!=null)
            {
                Mail::send(
                    'emails.forgetPassMail',
                    ["name" => $user->user_name,"otp"=>$fourRandomDigit],
                    function ($message) use ($toMail) {
                        $message->subject('Test Email');
                        $message->from('mhdmarwan111@gmail.com', config("app.name"));
                        $message->to($toMail);
                    }
                );

                return view('forgetPassOtpCheck',['user_id' => $user->user_id,'name'=>$user->user_name]);

            }else{
                return redirect()->route('forgetPass')->with('message', 'The Mail Id does not exist !');
            }
        }

        public function checkOtpAndUpdate(Request $request)
        {
            // $request->all();
            $check = UserOtpCheck::leftjoin('users','users.transaction_id','user_otp_checks.user_id')
                        ->where('users.user_id',$request->user_id)
                        ->where('user_otp_checks.otp',$request->otp)
                        ->count();
               if($check!=0)
               {
                return redirect('index');
               }
        }
}