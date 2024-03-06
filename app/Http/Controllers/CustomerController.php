<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
 
    public function indexPackage()
    {
        $customers = Customer::all();
        return view('whatsapp_package', compact('customers'));
    }

    public function importPackage(Request $request)
    {
        $request->validate([
            'import_file' => [
                'required',
                'file',
                'mimes:csv,xlsx,xls'
            ],
        ]);

        Excel::import(new CustomerImport, $request->file('import_file'));

        return redirect()->back()->with('status', 'Imported Successfully');
    }
}

