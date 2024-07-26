<?php

// namespace App\Livewire;

// use App\Models\Employee;
// use Livewire\Component;

// class EmployeeManager extends Component
// {
//     public $employees, $name, $employeeId, $showForm;
//     public function render()
//     {
//         $this->employees = Employee::all();
//         return view('livewire.employee-manager');
//     }


//     public function create()
//     {
//         Employee::create(['name' => $this->name]);
//         $this->resetInputFields();
//     }

//     public function edit($id)
//     {
//         $task = Employee::findOrFail($id);
//         $this->taskId = $id;
//         $this->name = $task->name;
//     }

//     public function update()
//     {
//         $this->validate([
//             'name' => 'required',
//         ]);

//         $task = Employee::find($this->taskId);
//         $task->update([
//             'name' => $this->name
//         ]);

//         $this->resetInputFields();
//     }

//     public function delete($id)
//     {
//         Employee::find($id)->delete();
//     }

//     private function resetInputFields()
//     {
//         $this->name = '';
//     }
// }

namespace App\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Employee;

class EmployeeManager extends Component
{
    public $employees;
    public $employeeId = '';
    public $registerNo = '';
    public $name = '';
    public $email = '';
    public $contactNo = '';
    public $dob = '';
    public $address = null;
    public $showForm = false;
    public $isEditing = false;
    public $confirmingDelete = false;
    public $deletingEmployeeId = null;

    // search text
    public $search = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:employees,email',
        'contactNo' => ['required', 'regex:/^(\+\d{1,3}[- ]?)?\d{10}$/'],
        'dob' => 'required|date|before:today',
        'registerNo' => 'required|unique:employees,register_no',
    ];

    public function mount()
    {
        $this->employees = Employee::all();
        $this->confirmingDelete = false;
    }

    public function render()
    {
        return view('livewire.employee-manager');
    }

    private function generateRegisterNo(){
        $lastEmployee = Employee::latest('id')->first();
        $lastId = $lastEmployee ? $lastEmployee->id : 0;
        $this->registerNo = "EMP". str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
    }
    public function showEmployeeForm($employeeId = null)
    {
        if ($employeeId) {
            $employee = Employee::find($employeeId);
            $this->name = $employee->name;
            $this->email = $employee->email;
            $this->contactNo = $employee->contact_no;
            $this->dob = $employee->dob;
            $this->employeeId = $employee->id;
            $this->address = $employee->address;
            $this->registerNo = $employee->register_no;
            $this->isEditing = true;
        } else {
            $this->resetForm();
            $this->isEditing = false;
        }
        $this->showForm = true;
    }

    public function submit()
    {
        \Log::info('Saving employee', [
            'name' => $this->name,
            'email' => $this->email,
            'contactNo' => $this->contactNo,
            'dob' => $this->dob
        ]);
        $this->validate([
        'name' => 'required|string|max:255',
        'email' => $this->isEditing 
        ? ['required', 'email', Rule::unique('employees')->ignore($this->employeeId)]
        : 'required|email|unique:employees,email',
        'contactNo' => $this->isEditing 
                    ?  ['required', 'regex:/^(\+\d{1,3}[- ]?)?\d{10}$/', Rule::unique('employees', 'contact_no')->ignore($this->employeeId)]
                    : ['required', 'regex:/^(\+\d{1,3}[- ]?)?\d{10}$/', 'unique:employees,contact_no'],
        'dob' => 'required|date|before:today',
        ]);

        if ($this->isEditing) {
            $employee = Employee::find($this->employeeId);
            $employee->update([
                'name' => $this->name,
                'email' => $this->email,
                'dob' => $this->dob,
                'contact_no' => $this->contactNo,
                'address' => $this->address,
                'register_no' => $this->registerNo,
            ]);
        } else {
            \DB::enableQueryLog();
            Employee::create([
                'name' => $this->name,
                'email' => $this->email,
                'dob' => $this->dob,
                'contact_no' => $this->contactNo,
                'address' => $this->address,
                'register_no' => $this->registerNo,
            ]);
            \Log::info( print_r(\DB::getQueryLog(), true));
        }

        $this->resetForm();
        $this->employees = Employee::all();
        $this->showForm = false;
    }

    public function confirmDelete($employeeId)
    {
        $this->confirmingDelete = true;
        $this->deletingEmployeeId = $employeeId;
    }

    public function delete()
    {
        Employee::find($this->deletingEmployeeId)->delete();
        $this->employees = Employee::all();
        $this->confirmingDelete = false;
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->dob = '';
        $this->address = '';
        $this->contactNo = '';
        $this->employeeId = null;
        $this->generateRegisterNo();
    }

    /**
     * search employees
     */
    public function searchEmployees(){
        \Log::info('search query', ['q' => $this->search]);
        $this->employees =  Employee::whereLike('name', $this->search )->get();
    }

    public function clearSearchEmployees(){
        $this->search = '';
        $this->employees =  Employee::all();
    }
    
}

