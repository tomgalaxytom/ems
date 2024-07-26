<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;

class EmployeesImport implements ToCollection, WithHeadingRow, WithValidation, WithUpserts
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Employee([
                'name' => $row['name'],
                'email' => $row['email'],
                'contact_no' => $row['contact_no'],
                'register_no' => $row['register_no'],
                'address' => $row['address'],
                 'dob' =>  $row['dob'],
                // 'dob' => \Carbon\Carbon::parse($row['dob']),
            ]);

    }

    public function collection(Collection $rows){
        foreach($rows as $rowId => $row){
            if ($row['register_no'] == "" ) continue;
            \Log::info('Row#' . $rowId, $row->toArray());
            $employee = Employee::where('register_no', $row['register_no'])->first();
            if( $employee ){
                $employee->name = $row['name'];
                $employee->email = $row['email'];
                $employee->contact_no = $row['contact_no'];
                $employee->address = $row['address'];
                $employee->dob = \Carbon\Carbon::parse($row['dob']);
                $employee->save();
            } else {
                Employee::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'contact_no' => $row['contact_no'],
                    'register_no' => $row['register_no'],
                    'address' => $row['address'],
                     'dob' =>  \Carbon\Carbon::parse($row['dob']),
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [];
        // return [
        //     'name' => 'required|string',
        //     'email' => 'required|email|unique:employees,email',
        //     'contact_no' => ['required', 'regex:/^(\+\d{1,3}[- ]?)?\d{10}$/'],
        //     'register_no' => 'required|unique:employees,register_no',
        //     'dob' => 'required|before:today',
        // ];
    }

    public function customValidationMessages()
    {
        return [
            'email.unique' => 'The email address has already been taken.',
            'contact_no'    => 'The contact no format is invalid',
            'register_no.unique' => 'The regiser number has already been taken.',
            'dob.before' => 'The date of birth must be a date before today.',
        ];
    }

    public function uniqueBy()
    {
        return 'register_no';
    }
}

