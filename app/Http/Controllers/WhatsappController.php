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

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class WhatsappController extends Controller
{
    public function whatsapp(){
        $whatsapp = Whatsapp::all();
        return view('whatsapp', compact('whatsapp'));
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

    public function scrape(){
        $client = new Client();

        try {
            $response = $client->request('GET', 'https://portfolio.helpsx.com/');
            $html = $response->getBody()->getContents();
            // dd($html);
            

            $crawler = new Crawler($html);

            // For example, to extract the title of the page:
            $title = $crawler->filter('title')->text();
            echo "Title: $title\n";

            // Example: Extracting text from a specific element with class "some-class"
            $text = $crawler->filter('.css-901oao')->text();
            echo "<br>Text: $text\n";

            // Example: Extracting href attribute from links
            $links = $crawler->filter('a')->extract(['href']);
            foreach ($links as $link) {
                echo "<br>Link: $link\n";
            }

            //  Filter <button> elements
             $button = $crawler->filter('button');
             foreach ($button as $item) {
                 echo "<br> Button: " . $item->textContent . "\n";
             }

            $h1Elements = $crawler->filter('h1');
            foreach ($h1Elements as $element) {
                echo "H1 Element: " . $element->textContent . "\n";
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}

// public function whatsapp(){
//     $response = Http::get('https://jsonplaceholder.typicode.com/posts');
//     if ($response->successful()) {
//         $posts = $response->json();
//             return view('whatsapp', compact('posts'));
//         } else {
//         return redirect()->back()->with('error', 'Failed to fetch data from the API.');
//     }
//     @foreach ($posts as $item)
//     <span>{{ $item['userId'] }}</span>
//     <span>{{ $item['id'] }}</span>
//     @endforeach
// }
