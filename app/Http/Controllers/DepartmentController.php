<?php

namespace App\Http\Controllers;
use App\Company;
use App\Department;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
class DepartmentController extends Controller
{
    public function get_data(){
        $items = [];
        $items["Company"]=Company::select('company_code','company_name')
                        ->where('deleted_at' , null)
                        ->get();
 
        $items["Department"]=Department::from('departments as dep')
                -> select( 'dep.department_code', 
                'dep.department_name' ,
                 'com.company_name' , 
                 'dep.company_code',
                  'dep.created_at' , 
                  'dep.deleted_at',
                  'dep.updated_at' , 
                  'emp.employee_name') 
                  ->where('dep.deleted_at' , null)
                  ->where('com.deleted_at' , null )
                ->join('companies as com' , 'dep.company_code' ,'=',  'com.company_code')
                ->join('employees as emp' , 'emp.employee_code' , 'dep.updated_by')
                ->get();
                
        // return view('department' , compact('data','items' ));
        return $items;
    }

    public function insert_data(Request $req){
        $action=$req->input('action' );
        $company_code=$req->input('company_code' );
        $params_department=$req->input('department_name' );
        $company_code_orig=$req->input('company_code_orig');
        $department_code=$req->input('department_code');
        $exists=department::from('Departments as Dep')
                    ->select(  'Dep.company_code' ,  'department_name'   )
                    ->where('Dep.company_code' , '=' , strtoupper($company_code))
                    ->where( 'Dep.department_name'  , '=' , strtoupper($params_department))
                    ->get();
        $max=department::select(DB::raw('department_code + 1 as new_depCode'))
            ->where('company_code' , '=' , strtoupper($company_code))
            ->orderby('department_code' , 'desc')
            ->limit(1)
            ->get();


      $new_deptcode=str_pad(count($max)  > 0 ?   $max[0] ->new_depCode: '1' , 3 , '0' , STR_PAD_LEFT); 
        if( $action == 'DELETE'){
            Department::where('company_code' , $company_code)
                    ->where('department_code' , $department_code)
                    ->update(['deleted_at' => date('Y-m-d H:i:s'), 
                                'updated_at' =>  date('Y-m-d H:i:s') , 
                                'updated_by' => '00005']);
        
                    return $this->get_data(); 
        }
        else{
            if ( count($exists) == 0  &&  $params_department !=''  &&  $company_code !='' ) {          
                if( $action== 'ADD'){
                            Department::Insert(['company_code'=>$company_code , 
                             'department_code'=>  $new_deptcode , 
                             'department_name' =>strtoupper($params_department), 
                             'created_at'=>date('Y-m-d H:i:s') ,
                              'updated_at' =>date('Y-m-d H:i:s') , 
                            'updated_by' =>'00005']);
                        }  
               elseif( $action== 'UPDATE'){
                                    if($company_code != $company_code_orig ){

                                        Department::where('company_code' , $company_code_orig)
                                            ->where('department_code' , $department_code)
                                            ->delete();   

                                        Department::Insert([
                                                'company_code'=>$company_code , 
                                                'department_code'=> $new_deptcode  ,
                                                'department_name' =>strtoupper($params_department), 
                                                'created_at'=>date('Y-m-d H:i:s') , 
                                                'updated_at' =>date('Y-m-d H:i:s') ,
                                                'updated_by' =>'00005']);       
                                    }
                                
                                    elseif($company_code == $company_code_orig){
                                        Department::from('departments as dep')
                                            ->where('company_code' ,   $company_code_orig) 
                                            ->where('department_code', $department_code ) 
                                            ->update(['company_code'=> $company_code ,
                                            'department_name' =>  $params_department ,
                                            'updated_at' =>date('Y-m-d H:i:s') ,
                                            'updated_by' =>'00005']);   


                                            // test
                                    }   
                            }
                            return $this->get_data(); 
            }elseif( $params_department ==''   ||   $company_code =='' ){ 
                return 'blank';
            }elseif(count($exists)==1){
                    return 'exist';
            } 
        }
}
}



    

