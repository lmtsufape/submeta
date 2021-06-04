<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pdf;

class ExportController extends Controller
{    
    public function index()
    {
        // retreive all records from db
        $data = Employee::all();

        // share data to view
        view()->share('projeto.visualizar',$data);
        $pdf = PDF::loadView('pdf_view', $data);

        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }
 
    public function destroy($id)
    {
        
    }
}
