<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function register(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $testUser = User::where('email', $request->input('email'))->first();
        if(!empty($testUser)) {
            return response()->json(['status' => 'fail', 'error'=>'email already exists'],409);
        }

        $data = $request->all();
        $data['uuid'] = str_random(60);
        $user = User::create($data);
        if(!empty($user))
            return response()->json(['status'=>'success','userUid'=>$user->uuid],200);
        else return response()->json(['status' => 'fail'],401);
    }

    public function authenticate(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('password'), $user->password)) {
            $apikey = base64_encode(str_random(40));
            $user->update(['api_key' => "$apikey"]);
            return response()->json(['status' => 'success','api_key' => $apikey]);
        }else{
            return response()->json(['status' => 'fail'],401);
        }
    }

    //
}
