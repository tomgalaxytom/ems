<?php

namespace App\Livewire;

use App\Models\Employee;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportEmployeesPdf extends Component
{
    public $employees;
    public function mount(){
        $this->employees = Employee::all();
    }
    public function render()
    {
        return view('livewire.export-employees-pdf');
    }
    public function export(){
        // get employeee data from $this->employees

    // Convert Eloquent Collection to Array
    $employeesArray = $this->employees->toArray();

    // Generate the PDF content
    $pdfContent = Pdf::loadView('livewire.view-employees-pdf', ['employees' => $employeesArray])->output();

    // Stream the PDF file for download
    return response()->streamDownload(
        fn() => print($pdfContent),
        'filename.pdf',
        ['Content-Type' => 'application/pdf']
    );
    }
}
