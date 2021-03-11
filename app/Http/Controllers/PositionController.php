<?php

namespace App\Http\Controllers;
use App\Company;
use App\Position;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function get_data(){
        $items = [];
        $items["Company"]=Company::select('company_code','company_name')
        ->get();

        $items["Positions"]=Position::from('positions as pos')
                -> select( 'pos.position_code', 
                    'pos.position_name' ,
                    'com.company_name' , 
                    'pos.company_code',
                    'pos.created_at' , 
                    'pos.deleted_at',
                    'pos.updated_at' , 
                    'emp.employee_name') 
                  ->where('pos.deleted_at' , null)
                  ->where('com.deleted_at', null)
                ->join('companies as com' , 'pos.company_code' ,'=',  'com.company_code')
                ->join('employees as emp' , 'emp.employee_code' , 'pos.updated_by')
                ->orderby('com.company_code' , 'asc')
                ->get();
        // return view('position' , compact('data','items' ));
        return $items;
    }

    public function insert_data(Request $req){
        $action=$req->input('action' );
        $company_code=$req->input('company_code' );
        $params_position=$req->input('position_name' );
        $company_code_orig=$req->input('company_code_orig');
        $position_code=$req->input('position_code');
        $exists=position::from('positions as pos')
                    ->select(  'pos.company_code' ,  'position_name'   )
                    ->where('pos.company_code' , '=' , strtoupper($company_code))
                    ->where( 'pos.position_name'  , '=' , strtoupper($params_position))
                    ->get();
        $max=position::select(DB::raw('position_code + 1 as new_posCode'))
            ->where('company_code' , '=' , strtoupper($company_code))
            ->orderby('position_code' , 'desc')
            ->limit(1)
            ->get();
      $new_postcode=str_pad(count($max)  > 0 ?   $max[0] ->new_posCode: '1' , 3 , '0' , STR_PAD_LEFT); 
        if( $action == 'DELETE'){
            position::where('company_code' , $company_code)
                    ->where('position_code' , $position_code)
                    ->update(['deleted_at' => date('Y-m-d H:i:s'), 
                                'updated_at' =>  date('Y-m-d H:i:s') , 
                                'updated_by' => '00005']);
        
                    return $this->get_data(); 
        }

        else{
            if ( count($exists) == 0  &&  $params_position !=''  &&  $company_code !='' ) {    
                       
                if( $action== 'ADD'){
                            position::Insert(['company_code'=>$company_code , 
                             'position_code'=>  $new_postcode , 
                             'position_name' =>strtoupper($params_position), 
                             'created_at'=>date('Y-m-d H:i:s') ,
                              'updated_at' =>date('Y-m-d H:i:s') , 
                            'updated_by' =>'00005']);
                        }  
               elseif( $action== 'UPDATE'){
                                    if($company_code != $company_code_orig ){

                                        position::where('company_code' , $company_code_orig)
                                            ->where('position_code' , $position_code)
                                            ->delete();   

                                        position::Insert([
                                                'company_code'=>$company_code , 
                                                'position_code'=> $new_postcode  ,
                                                'position_name' =>strtoupper($params_position), 
                                                'created_at'=>date('Y-m-d H:i:s') , 
                                                'updated_at' =>date('Y-m-d H:i:s') ,
                                                'updated_by' =>'00005']);       
                                    }
                                
                                    elseif($company_code == $company_code_orig){
                                        position::from('positions as pos')
                                            ->where('company_code' ,   $company_code_orig) 
                                            ->where('position_code', $position_code ) 
                                            ->update(['company_code'=> $company_code ,
                                            'position_name' =>  $params_position ,
                                            'updated_at' =>date('Y-m-d H:i:s') ,
                                            'updated_by' =>'00005']);   
                                    }   
                            }
                            return $this->get_data(); 
            }elseif( $params_position ==''   ||   $company_code =='' ){ 
                return 'blank';
            }elseif(count($exists)==1){
                    return 'exist';
            } 
        }
}
}



    

