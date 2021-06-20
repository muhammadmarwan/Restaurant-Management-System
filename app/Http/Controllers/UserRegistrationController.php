<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransactionId\Transaction;
use App\Models\User;
use App\Common\UserStatus;
use Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class UserRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userName = Auth::user()->user_name;
        $userRole = Auth::user()->user_role;
        
        if(Auth::check()){
            return view('userReg',['name'=>$userName,'role'=>$userRole]);
        }
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

    public function storeUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'userRole' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'required|string',
            
        ]);

        $userCount = User::where('status',UserStatus::active)->count();

        $userId = 1000+$userCount;

        try {

            $userRegistration = new User();
            $userRegistration->transaction_id = Transaction::setTransactionId();
            $userRegistration->user_id = $userId;
            $userRegistration->user_name = $request->name;
            $userRegistration->user_role = $request->userRole;
            $userRegistration->email_id = $request->email;
            $userRegistration->phone_number = $request->phone;
            $userRegistration->password = bcrypt($request->password);
            $userRegistration->save();

            Alert::Success('Registered', 'User Registered Successfully');

            return redirect('view');        
        }
            
        catch (Exception $e){

            return json_encode(array("status" => 300));
        }
    }

    public function userView(Request $request)
    {
        $userList = User::where('status',UserStatus::active);

        if ($request->has('name') && !empty($request->name)) {
            $userList = $userList->where('user_name','LIKE', "%$request->name%");
        }
        $userList = $userList->get();

        foreach($userList as $user)
        {
            if($user->user_role==1)
            {
                $user->role='Admin';
            }if($user->user_role==2)
            {
                $user->role='Accountant';
            }if($user->user_role==3)
            {
                $user->role='Cashier';
            }if($user->user_role==4)
            {
                $user->role = 'Kitchen';
            }

            if($user->status==0)
            {
                $user->activity='Active';
            }else{
                $user->activity='Deactive';
            }

           $user->date = date('d-m-Y', strtotime($user->created_at));
        }

        $userName = Auth::user()->user_name;
        $userRole = Auth::user()->user_role;

        $request->name=null;

        return view('userView',['userList'=>$userList,'name'=>$userName,'role'=>$userRole]);
    }

    public function userEdit($id)
    {
        $user = User::where('id',$id)->first();
        $name = Auth::user()->user_name;

        return view('userEdit',['user'=>$user,'name'=>$name]);
    }

    public function updateUserDetails(Request $request)
    {
        if($request->userName!=null&&$request->email!=null&&$request->phone!=null&&$request->userRole!=null)
        {
            $update = User::where('user_id',$request->userId)->update(['user_name'=>$request->userName,'email_id'=>$request->email,
            'phone_number'=>$request->phone,'user_role'=>$request->userRole]);

            Alert::Success('Updated', 'User Updated Successfully');
        }else{

            Alert::Warning('Alert', 'Please make sure all fields are filled');
        }
        
        return redirect('view');    
    }

    public function deleteUser(Request $request)
    {
        $user = User::where('user_id',$request->userId)->delete();

        Alert::Success('Deleted', 'User Deleted');

        return redirect('view'); 
    }

    public function changeUserPassword(Request $request)
    {
        if($request->pass==$request->confPass)
        {
            $userUpdate = User::where('id',$request->id)
            ->update(['password'=>bcrypt($request->pass)]);

            return redirect('view')->with('message', 'Password Updated Successfully!');

        }else{
            return redirect('view')->with('message2', 'Please make sure  your password match!');
        }
    }
}