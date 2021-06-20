<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Country;
use App\Models\Employee;
use App\TransactionId\Transaction;
use App\Models\EmployeeSalary;
use Carbon\Carbon;
use App\Models\EmployeeSalaryPerMonth;
use PDF;
use App\Models\SalarySetup;
use App\Models\SubAccounts;
use Illuminate\Support\Facades\DB;
use App\Common\AccountType;
use App\Models\TransactionDetails;
use App\Common\TransactionType;
use RealRashid\SweetAlert\Facades\Alert;

class PayrollManagementController extends Controller
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

    public function employeeList()
    {
        $name = Auth::user()->user_name;

        $nationality = Country::all();

        $employees = Employee::all();

        return view('payroll.employee',['name'=>$name,'employees'=>$employees,'nationality'=>$nationality]);
    }

    public function employeeStore(Request $request)
    {        
        $employeeId = Employee::max('id');

        if(isset($request->employeeName) && isset($request->designation) && isset($request->employeeAge)
        && isset($request->doj) && isset($request->emiratesId) && isset($request->nationality)
        && isset($request->emailId) && isset($request->phone) && isset($request->basicSalary)
        && isset($request->allowances) && isset($request->salary))
        {
        $employee = new Employee();
        $employee->transaction_id = Transaction::setTransactionId();
        $employee->name = $request->employeeName;
        $employee->designation = $request->designation;
        $employee->employee_id = 1000 + $employeeId;
        $employee->age = $request->employeeAge;
        $employee->date_of_joining = $request->doj;
        $employee->emirates_id = $request->emiratesId;
        $employee->nationality = $request->nationality;
        $employee->email_id = $request->emailId;
        $employee->phone = $request->phone;
        $employee->save();

        $employeeSalary = new EmployeeSalary();
        $employeeSalary->transaction_id = Transaction::setTransactionId();
        $employeeSalary->employee_id = $employee->employee_id;
        $employeeSalary->employee_table_id = $employee->transaction_id;
        $employeeSalary->basic_salary = $request->basicSalary;
        $employeeSalary->other_allowances = $request->allowances;
        $employeeSalary->gross_salary_payable = $request->salary;
        $employeeSalary->save();

        Alert::success('Success');
        return redirect()->back();
        }
        
        Alert::error('Error');

    }

    public function employeeEdit(Request $request)
    {
        $name = Auth::user()->user_name;

        $nationality = Country::all();
        
        $employee = Employee::where('employees.employee_id',$request->id)
        ->leftjoin('employee_salaries','employee_salaries.employee_id','employees.employee_id')
        ->first();

        // return $employee;

        return view('payroll.employeeEdit',['name'=>$name,'employee'=>$employee,'nationality'=>$nationality]);
    }

    public function employeeUpdate(Request $request)
    {
        if(isset($request->employeeName) && isset($request->designation) && isset($request->employeeAge)
        && isset($request->doj) && isset($request->emiratesId) && isset($request->nationality)
        && isset($request->emailId) && isset($request->phone) && isset($request->basicSalary)
        && isset($request->allowances) && isset($request->salary))
        {
            $updateEmployee = Employee::where('employee_id',$request->employeeId)
            ->update(['name'=>$request->employeeName,'designation'=>$request->designation,'age'=>$request->age,
            'date_of_joining'=>$request->doj,'emirates_id'=>$request->emiratesId,'nationality'=>$request->nationality,
            'email_id'=>$request->emailId,'phone'=>$request->phone]);
    
            $totalSalary = $request->basicSalary+$request->otherAllowances;
    
            $updateSalaryDetails = EmployeeSalary::where('employee_id',$request->employeeId)
            ->update(['basic_salary'=>$request->basicSalary,'other_allowances'=>$request->otherAllowances,
            'gross_salary_payable'=>$totalSalary]);

            Alert::success('Updated');
            return redirect('employeeList');
        }else{
            Alert::error('Error','Please fill all fields');
            return redirect()->back();
        }      
    }

    public function salary()
    {
        $name = Auth::user()->user_name;

        $date = Carbon::now();

        $lastMonth =  $date->subMonth()->format('F');

        $year =  $date->subMonth()->format('Y');

        $employees = Employee::all();

        $sumOfSalary = EmployeeSalaryPerMonth::where('month',$lastMonth)->where('year',$year)
        ->where('paid_status',0)
        ->sum('net_salary');

        foreach($employees as $employee)
        {
            $employeeCheckSalary = EmployeeSalaryPerMonth::where('employee_id',$employee->employee_id)
            ->where('month',$lastMonth)->where('year',$year)->first();

            if($employeeCheckSalary)
            $employee->salary = $employeeCheckSalary->net_salary;
        }

        return view('payroll.salarySheet',['name'=>$name,'employees'=>$employees,'lastMonth'=>$lastMonth,
        'salarySum'=>$sumOfSalary]);
    }

    public function salarySheet(Request $request)
    {
        $post = Employee::where('id',$request->id)->first();

        return view('payroll.salarySheet',compact('post'));
    }

    public function createSalarySheet(Request $request)
    {
        $name = Auth::user()->user_name;

        return view('payroll.createSalarySheet',['name'=>$name,'employeeId'=>$request->employeeId]);
    }

    public function salarySheetStore(Request $request)
    {
        if(!isset($request->totalDays))
        {
            return redirect()->route('salary');
        }

        $employeeTable = Employee::where('employee_id',$request->employeeId)->value('transaction_id');

        $salarySheet = new EmployeeSalaryPerMonth();
        $salarySheet->transaction_id = Transaction::setTransactionId();
        $salarySheet->employee_id = $request->employeeId;
        $salarySheet->employee_table_id = $employeeTable;
        $salarySheet->month = $request->month;
        $salarySheet->year = $request->year;
        $salarySheet->total_working_days = $request->totalDays;
        if($request->leaveDays==null)
            $request->leaveDays=0;
        $salarySheet->leave_days = $request->leaveDays;
        $salarySheet->salary = $request->salaryPerMonth;
        if($request->bonus==null)
            $request->bonus=0;
        $salarySheet->bonus = $request->bonus;
        if($request->deduction==null)
            $request->deduction=0;
        $salarySheet->deductions = $request->deduction;
        $salarySheet->advance = $request->advance;
        $salarySheet->net_salary = $request->totalNetSalary;
        $salarySheet->save();
        
        Alert::success('Success',);
        return redirect('salary');
    }

    public function salaryReport()
    {
        $name = Auth::user()->user_name;

        return view('payroll.salaryReport',['name'=>$name]);
    }

    public function salaryReportResult(Request $request)
    {
        $name = Auth::user()->user_name;

        $month = Carbon::parse($request->month)->format('F');

        $year = Carbon::parse($request->month)->format('Y');

        $salaryReport = Employee::leftjoin('employee_salary_per_months','employee_salary_per_months.employee_id','employees.employee_id')
        ->where('employees.status',0)
        ->where('employee_salary_per_months.month',$month)
        ->where('employee_salary_per_months.year',$year)
        ->get();

        return view('payroll.salaryReportResult',['name'=>$name,'salaryReport'=>$salaryReport,'month'=>$month,'year'=>$year]);
    }

    public function printSalaryReport(Request $request)
    {
        $salaryReport = Employee::leftjoin('employee_salary_per_months','employee_salary_per_months.employee_id','employees.employee_id')
        ->where('employees.status',0)
        ->where('employee_salary_per_months.month',$request->month)
        ->where('employee_salary_per_months.year',$request->year)
        ->get();

        $today = Carbon::now()->format('d-F-Y');

        $pdf = PDF::loadView('pdf.salaryReport',['today'=>$today,'salaryReport'=>$salaryReport,
        'month'=>$request->month,'year'=>$request->year]);

        //  download PDF file with download method
        return $pdf->download('SalaryReport'.($request->month.'-'.$request->year).'.pdf');
    }

    public function salarySetup()
    {
        $name = Auth::user()->user_name;

        $count1 = SalarySetup::where('id',1)->value('account_id');

        $count2 = SalarySetup::where('id',2)->value('account_id');

        $accounts = SubAccounts::leftjoin('main_accounts','main_accounts.account_id','sub_accounts.parent_account_id')
        ->select(DB::raw("CONCAT(sub_accounts.account_name,'(',main_accounts.account_name,')') AS label"),'sub_accounts.transaction_id as value')
        ->where('degree',AccountType::Normal)
        ->orWhere('degree',AccountType::PayAndReceive)
        ->get();

        return view('payroll.salarySetup',['name'=>$name,'accounts'=>$accounts,
        'count1'=>$count1,'count2'=>$count2]);
    }

    public function storeSalarySetup(Request $request)
    {
        $salarySetup = SalarySetup::where('id',$request->type)
        ->update(['account_id'=>$request->account]);

        Alert::success('Success');
        return redirect()->back();
    }

    public function salaryPublish()
    {
        $date = Carbon::now();

        $lastMonth =  $date->subMonth()->format('F');

        $year =  $date->subMonth()->format('Y');

        $employees = Employee::all();

        $sumOfSalary = EmployeeSalaryPerMonth::where('month',$lastMonth)->where('year',$year)
        ->sum('net_salary');

        $updateStatus = EmployeeSalaryPerMonth::where('month',$lastMonth)->where('year',$year)
        ->update(['paid_status'=>1]);

        $creditAccount = SalarySetup::where('account_type','Salary Payable')->value('account_id');

        $debitAccount = SalarySetup::where('account_type','Salary Receivable')->value('account_id');

        $transaction1 = new TransactionDetails();
        $transaction1->transaction_id = Transaction::setTransactionId();
        $transaction1->type = TransactionType::sale;
        $transaction1->credit_account = $creditAccount;
        $transaction1->debit_account = $debitAccount;
        $transaction1->amount = $sumOfSalary;
        $transaction1->bill_no = null;
        $transaction1->narration = Carbon::now()->format('d-F-Y') .' Salary Publish';
        $transaction1->date = Carbon::today();
        $transaction1->save();
        
        Alert::success('Success');

        return redirect()->back();
    }

    public function deleteEmployee(Request $request)
    {
        $employeeDelete = Employee::where('id',$request->userId)->delete();

        Alert::success('Success','Employee Deleted Successfully');

        return redirect()->back();
    }
    
}