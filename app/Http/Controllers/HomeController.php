<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//         // return view('home');
//         // $userList = User::paginate(10);
//         // $totalusers = $userList->total();
//         $redis    = Redis::connection();
// $response = $redis->get('user_details');

// // $response = json_decode($response);
//     $r = $this->loggedUsers();
// print_r($r);dd('ok');
        return view('home');
        //return view('admin.list',compact('userList','totalusers'));
    }

public function loggedUsers($cursor=null, $allResults=array())
    {
        // Zero means full iteration
        if ($cursor==="0"){
            // Get rid of duplicated values caused by redis scan limitations.
            $allResults = array_unique($allResults);
            // Setting users array
            $users = array ();
            // Looping through all results. Inserting each logged user into array.
            foreach($allResults as $result){
                $users[] = User::where('id',Redis::Get($result))->first();
            }
            // Removing duplicate items. (If user has logged in using more than one machine)
            $users = array_unique($users);
            return $users;
        }

        // No $cursor means init
        if ($cursor===null){
            $cursor = "0";
        }

        // The call
        $result = Redis::scan($cursor, 'match', 'users:*');

        // Append results to array
        $allResults = array_merge($allResults, $result[1]);

        // Recursive call until cursor is 0
        return self::loggedUsers($result[0], $allResults);
    }
}
