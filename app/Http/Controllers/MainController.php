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

    public function passwordChange()
    {

        $data['page_title'] = 'Change User Password';
        return view('passwordchange',$data, ['savedPassword' => false]);
    }

    public function updatePassword(Request $request)
    {
        // Prepare the API data
        $data = [
            'email' => $request->email,
            'newPassword' => $request->password,
            'changeToken' => "Fw4blJo0Cv9YM74mpH9reWIyQmvilb90RtoS6mFHhkw",
            'api_key' => "iw56io43dfgh56djka453lskjfhj283jd64hw88djbu3jgldkl705896als54k778d5g",
        ];

        // Call the external API using HTTP client (Laravel's HTTP client)
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://sjvv8a3ys1.execute-api.us-east-1.amazonaws.com/Dev/newForgotPassword', $data);

        // Check if the request was successful
        if ($response->successful()) {
            $responseBody = $response->json()['body'];
            // Pass the API response data to the view
            return view('passwordchange', ['savedPassword' => true, 'page_title' => 'Change User Password']);
        }

        // In case of failure, pass an error message to the view
        return back()->with('error', 'Something went wrong. Please try again.');
    }

    public function history($email)
    {

        // Prepare the API data
        $data = [
            'useremail' => $email,
        ];


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://pastorchrisdigitallibrary.org/pcdl_app_v6/get_user_transaction_history.php', $data);

        // Check if the request was successful
        if ($response->successful()) {
            $responseBody = $response->json()['data'];
            // Pass the API response data to the view
            return view('history', ['userHistory' => $responseBody, 'page_title' => 'User History']);

        }

        // In case of failure, pass an error message to the view
        return back()->with('error', 'Something went wrong. Please try again.');
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
            'apiKey' => 'fa787as2efsdvjsudfisyiukkdf',
        ];

        // Call the external API using HTTP client (Laravel's HTTP client)
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://sjvv8a3ys1.execute-api.us-east-1.amazonaws.com/Dev/checkPCDLUser', $data);

        // Check if the request was successful
        if ($response->successful()) {
            $responseBody = $response->json()['body'];
            // Pass the API response data to the view
            return view('user', ['userData' => $responseBody, 'page_title' => 'User Details']);
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
