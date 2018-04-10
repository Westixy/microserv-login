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

    /**
     * create an user 
     */
    public function register(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $testUser = User::where('email', $request->input('email'))->first();
        if(!empty($testUser)) {
            return response()->json(['status' => 'fail', 'error'=>'email already exists'],409);
        }

        $data = $request->all();
        $data['password'] = Hash::make($request->input('password'));
        $uuid = str_random(60);
        while(!empty(User::where('uuid', $uuid)->first())) $uuid = str_random(60);
        $data['uuid'] = $uuid;
        $user = User::create($data);
        if(!empty($user))
            return response()->json(['status'=>'success','message'=>'user created : '.$user->email,'userUid'=>$user->uuid,'userId'=>$user->id],200);
        else return response()->json(['status' => 'fail'],401);
    }

    /**
     * try to login with email and password so it will give back the userUid
     */
    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if(empty($user)) return response()->json(['status' => 'fail', 'error'=>'user not found : '.$request->input('email')],401);
        if(Hash::check($request->input('password'), $user->password)) {
            return response()->json(['status' => 'success','userUid' => $user->uuid]);
        }else{
            return response()->json(['status' => 'fail', 'error' => 'email and password does not match'],401);
        }
    }

    /**
     * obtain the mail and id from an uid of an user
     */
    public function getLogin(Request $request) {
        $this->validate($request, [
            'uuid' => 'required'
        ]);
        $user = User::where('uuid', $request->input('uuid'))->first();
        if(empty($user)) return response()->json(['status' => 'fail', 'error'=>'user not found : '.$request->input('uuid')],401);
        else return response()->json(['status' => 'success', 'userUid' => $user->uuid, 'email'=> $user->email,'userId'=>$user->id],200);
    }

    /**
     * reset the password of the user
     */
    public function resetPassword(Request $request) {
        $this->validate($request, [
            'uuid' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('uuid', $request->input('uuid'))->first();
        if(empty($user)) return response()->json(['status' => 'fail', 'error'=>'user not found : '.$request->input('uuid')],401);
        else {
            $user->update(['password'=> Hash::make($request->input('password'))]);
            return response()->json(['status' => 'success', 'message'=>'password updated' ,'userUid' => $user->uuid, 'email'=> $user->email,'userId'=>$user->id],200);
        }
    }

    /**
     * update uid
     */
    public function updateUid(Request $request) {
        $this->validate($request, [
            'uuid' => 'required'
        ]);
        $user = User::where('uuid', $request->input('uuid'))->first();
        if(empty($user)) return response()->json(['status' => 'fail', 'error'=>'user not found : '.$request->input('uuid')],401);
        else {
            $uuid = str_random(60);
            while(!empty(User::where('uuid', $uuid)->first())) $uuid = str_random(60);
            $user->update(['uuid'=>$uuid]);
            return response()->json(['status' => 'success', 'message' => 'user uid updated', 'uuid'=> $uuid],200);
        }
    }

    /**
     * delete an user
     */
    public function delete(Request $request) {
        $this->validate($request, [
            'uuid' => 'required'
        ]);
        $user = User::where('uuid', $request->input('uuid'))->first();
        if(empty($user)) return response()->json(['status' => 'fail', 'error'=>'user not found : '.$request->input('uuid')],401);
        else {
            $email = $user->email;
            $user->forceDelete();
            return response()->json(['status' => 'success', 'message' => 'user deleted', 'email'=> $email],200);
        }
    }
}
