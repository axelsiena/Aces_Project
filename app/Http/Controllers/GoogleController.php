<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(){
        
        $userGoogle=Socialite::driver('google')->stateless()->user();
        
        $foundUser=User::where('google_id',$userGoogle->id)->first();

        if($foundUser){
            Auth::login($foundUser);
        }else{

            $foundUser=User::where('email',$userGoogle->email)->first();

            if($foundUser){
                $foundUser->google_id=$userGoogle->id;
                $foundUser->save();
                Auth::login($foundUser);
            }else{
                $newUser = User::create([
                    'name' => $userGoogle->name,
                    'email' => $userGoogle->email,
                    'google_id' => $userGoogle->id,
                    'password' => encrypt('')
                ]);
        
                Auth::login($newUser);
            }            
        }
        
        return redirect('/ad/new');

    }
}
