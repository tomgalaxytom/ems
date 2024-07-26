<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeesImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
class ImportEmployees extends Component
{
    use WithFileUploads;

    public $file;
    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:10240', // Max 10 MB
        ]);

        try {
            Excel::import(new EmployeesImport, $this->file);

            session()->flash('message', 'Employees imported successfully.');
            return Redirect::to('/home');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'There was an error importing the file.');
        }

        $this->reset('file');
    }

    
    public function render()
    {
        return view('livewire.import-employees');
    }
}
