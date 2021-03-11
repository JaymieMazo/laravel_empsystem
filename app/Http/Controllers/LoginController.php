<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class LoginController extends Controller
{
    //
    public function login(Request $req){

        // return $req;        
        $email=$req->input('email');
        $pword=$req->input('pword');
        // return $email;
        $isExists=User::select('email' , 'password')
                        ->where('email' , $email)
                        ->where('password' ,$pword)
                        ->get();

return count($isExists);

    }
}
