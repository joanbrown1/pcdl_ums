<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Zone;
use App\Jobs\SyncGroupsJob;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MainController extends Controller
{
    public function user()
    {

        $data['page_title'] = 'User';
        return view('user',$data);
    }

    public function home()
    {

        $data['page_title'] = 'Search';
        return view('search',$data);
    }

    public function searchUser(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
        ]);

        // Prepare the API data
        $data = [
            'email' => $request->email,
            'apiKey' => 'fa787as2efsdvjsudfisyiukkdf', // Example API Key, replace with actual
        ];

        // Call the external API using HTTP client (Laravel's HTTP client)
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://sjvv8a3ys1.execute-api.us-east-1.amazonaws.com/Dev/checkPCDLUser', $data);

        // Check if the request was successful
        if ($response->successful()) {
            $responseBody = $response->json()['body'];
            // Pass the API response data to the view
            return view('user', ['userData' => $responseBody]);
        }

        // In case of failure, pass an error message to the view
        return back()->with('error', 'Something went wrong. Please try again.');
    }





    public function logout()
    {
        session()->flush();
        return to_route('login');
    }


}
