<?php

namespace App\Http\Controllers;

use App\Mail\DemoMail;
use App\Mail\VerifyMail;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Mail;
class user extends Controller
{
    public function sign_up()
    {
        $signup_user = request()->all();
        unset($signup_user['_token']);
        $signup_user['active'] = 0;
        $signup_user['private'] = 0;
        $signup_user['profile'] = 'anon.jpg';



        $user_username = \App\models\user::where('username',$signup_user['username'])->get()->toArray();
        $user_email = \App\models\user::where('email',$signup_user['email'])->get()->toArray();


        if($user_username){
            return redirect(route('user.sign_up'))->with('message','this username is used before!!');
        }
        if($user_email){
            return redirect(route('user.sign_up'))->with('message','this email is used before!!');
        }



        $signed_up = \App\models\user::create($signup_user);

        if(!$signed_up instanceof \App\models\user){
            return redirect(route('user.sign_up'))->with('message','some error happened !!');
        }
        // sending email to user

        $verifyUser = \App\VerifyUser::create([
            'user_id' => $signed_up->user_id,
            'token' => str_random(40)
        ]);

        //dd($signed_up->VerifyUser);
        try{
            Mail::to($signed_up->email)->send(new VerifyMail($signed_up));
        }catch (Exception $e){
            \App\models\user::where('username',$signup_user['username'])->delete();
            return redirect(route('user.sign_up'))->with('message','some errors happen try later!!');
        }


        //end

        return redirect(route('user.login'))->with('email_message','we have sent you an email for validation');

    }
    public function login()
    {

        $username= request()->input('username');
        $password =request()->input('password');

        //$users = \App\models\user::all();
        $users = \App\models\user::where('username',$username)->get()->toArray();



        if($users){
            if($users[0]['active']==0) {
                return redirect()->route('user.login')->with('message','you are not active yet!!');
            }else{
                if($users[0]['password']==$password){
                    setcookie('signed',$username , time() + 3600*2, "/");
//                    Cookie('signed','in',true,1);
//                    print_r($_COOKIE);
                    return redirect()->route('user.home');
                }else{
                    return redirect()->route('user.login')->with('message','wrong password');
                }
            }
        }else{
            return redirect()->route('user.login')->with('message','there is no person with this username!!');
        }

    }
    public function active($token)
    {
        $t = \App\VerifyUser::where('token',$token)->first();
        $t->user->active = 1;
        $t->user->save();
        return redirect()->route('user.login');
    }
}
