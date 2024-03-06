<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Whatsapp;
use Session;

class WhatsappController extends Controller
{
    public function whatsapp(){
        $whatsapp = Whatsapp::all();
        return view('whatsapp', compact('whatsapp'));


        // $response = Http::get('https://jsonplaceholder.typicode.com/posts');
        // if ($response->successful()) {
        //     $posts = $response->json();
        //         return view('whatsapp', compact('posts', 'whatsapp'));
        //     } else {
        //     return redirect()->back()->with('error', 'Failed to fetch data from the API.');
        // }
        // @foreach ($posts as $item)
        // <span>{{ $item['userId'] }}</span>
        // <span>{{ $item['id'] }}</span>
        // @endforeach
    }
    
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'import_file' => 'required|mimes:csv|max:2048',
        ]);

        $file = $request->file('import_file');
        $csvData = array_map('str_getcsv', file($file));

        foreach ($csvData as $row) {
            $match  = '1723629080';
            $name   = $row[0] ?? 'null';
            $phone  = $row[1] ?? 'null';
            $number = $row[1] ?? 'null';
            if (empty($number)) {
                $number = '1718513591';
            }
            $url    = 'https://web.whatsapp.com/send/?phone=' . $number . '&text&type=phone_number&app_absent=0';
            
            $status = $row[2] ?? 0;

            if ($phone === $match) {
                $status = 1; 
            } else {
                $status = 0;
            }
            Whatsapp::create([
                'name'   => $name, 
                'phone'  => $phone, 
                'url'    => $url,
                'status' => intval($status), 
            ]);
        }

        return redirect()->route('import')->with('success', 'CSV file uploaded and processed successfully.');
    }

}
