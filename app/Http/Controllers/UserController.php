<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
Use App\User;

class UserController extends Controller
{
    public function get_data(){
        $data= User::from('users as u')
                    -> select('u.id', 'u.name' , 'u.email' , 'u.created_at' , 'u.deleted_at' ,
                     'u.updated_at' , 'emp.employee_name')->join('employees as emp' , 
                     'u.updated_by' , '=' , 'emp.employee_code')->get();
    return $data;
    } 

    public function insert_data(Request  $req){
        $isAction=  $req->input('IsAction');
        $email=$req->input('email');
        $name=$req->input('name');
        $pword=$req->input('pword');
        $id=$req->input('id');

        $if_exist=User::select('email')
       ->where('email' , strtoupper($email))
       ->get();



   
    if( $isAction == 'DELETE'){
                User::where('email' , $email)
                                ->update([
                                    'deleted_at' => date('Y-m-d H:i:s'), 
                                    'updated_at' =>  date('Y-m-d H:i:s') , 
                                    'updated_by' => '34782'
                                ]);
        return   $this->get_data();
    }
    
    else{
        if($isAction=='ADD'   &&  count($if_exist ) == 0  ){ 
                    if($email != ''  && $name != '' and $pword != '' ) {
                            User::Insert(['email' =>$email,
                                            'name'=>$name,
                                            'password' =>strtoupper($pword),
                                            'created_at'=>date('Y-m-d H:i:s') ,
                                            'updated_at' =>date('Y-m-d H:i:s') ,
                                            'updated_by' =>'34782']);
                                            return   $this->get_data();
                    }
        }elseif ($isAction == 'UPDATE'  ){ 
                    if($email != ''  && $name != ''){
                        User::where('id' ,   $id)
                            ->update(['email' => $email,'name' => $name]); 
                         return   $this->get_data();
                        }

         }elseif(count($if_exist ) <> 0   && ($email != ''  && $name != '' && $pword != '' )){
            return 'exist';  

        }elseif(count($if_exist ) == 0 &&  ($email == ''   || $name == '' || $pword == '' )){
         return  'blank' ;
        }
    }
}
}
