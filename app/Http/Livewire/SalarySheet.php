<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\EmployeeSalary;

class SalarySheet extends Component
{
    public $date,$lastMonth,$employee,$deductAmount,$bonusAmount;
    public $employeeId,$employeeSalary,$totalNetSalary,$today,$year;

    public function mount()
    {
        $date = $this->date = Carbon::now();

        $this->today = $date->format('d-F-Y');

        $this->lastMonth =  $date->subMonth()->format('F');

        $this->year =  $date->subMonth()->format('Y');

        $this->employee = Employee::where('employee_id',$this->employeeId)->first();

        $this->employeeSalary = EmployeeSalary::where('employee_id',$this->employeeId)->first();

        $this->totalNetSalary = $this->employeeSalary->gross_salary_payable;
    }
    
    public function render()
    {
        return view('livewire.salary-sheet');
    }

    public function Deduction()
    {
        $employeeSalary = $this->employeeSalary->gross_salary_payable;

        $this->totalNetSalary = (int)$employeeSalary - (int)$this->deductAmount;
    }

    public function Bonus()
    {
        $employeeSalary = $this->employeeSalary->gross_salary_payable;

        $this->totalNetSalary = (int)$employeeSalary + (int)$this->bonusAmount;
    }
}
