<?php

Namespace App\Http\Controllers;
use App\Company;
use App\Department;
use App\Section;
use App\Employee;
use App\employee_contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function get_data(){
    $items=[];
    $items["Company"]=Company::all();
    $items["Department"]=Department::all();
    $items["Section"]=Section::all();
    $items["Employee"]=  Employee::from('employees as e')    
        ->select('e.employee_code'  , 'e.employee_name'  ,     
                DB::raw( 'CASE WHEN e.gender=1 then "male" else "female" end as gender_name' ),   
                DB::raw( 'CASE WHEN e.contract_status="c" then "Contractual" else "Regular" 
                end as contract_status' ) , 'e.age' , 'e.birthday' , 'e.civilstatus'  ,
                 'e.nationality' , 'e.religion' , 'e.children'   , 'con.cp_no' , 'con.tel_no' , 'con.email' ,'con.contact_person' , 'con.con_cpno',
                'con.address'  , 'e.gender' , 'e.contract_status'  ,  'e.company_code' , 
                'e.department_code' , 'e.section_code' , 'c.company_name' ,
                 'd.department_name' , 's.section_name' , 'e.hired_date' , 'e.retired_date')     
        ->where('e.deleted_at' , null)
        ->join('companies as c' , 'c.company_code' , '=' , 'e.company_code')    
        ->join('departments as d' , function($join)
                { $join->on('d.company_code' , '=' , 'e.company_code')
                ->on('d.department_code','=' , 'e.department_code');})     
        ->join('sections as s' , function($join){
                    $join->on('s.company_code' , '=' , 'e.company_code')             
                        ->on('s.department_code' , '=' , 'e.department_code' )             
                        ->on('s.section_code' , '=' , 'e.section_code');})
        ->Leftjoin('employee_contacts as con' , 'e.employee_code' , '=' , 'con.employee_code' )
        ->get();

        // return view('section' , compact('company' , 'dept', 'sections' ));
        return   ($items);
    } 

    public function insert_data(Request $req){
        $action=$req->input('action');
        $params_company=$req->input('company_code' );
        $params_department=$req->input('department_code' );
        $params_section=$req->input('section_code' );
        $employee_code=$req->input('employee_code');
        $employee_name=$req->input('employee_name');
        $gender=$req->input('gender');
        $status=$req->input('contract_status');
        $company_code_orig=$req->input('company_code_orig' );
        $department_code_orig=$req->input('department_code_orig' );
        $section_code_orig=$req->input('section_code_orig' );
        $age=$req->input('age');
        $bday=$req->input('birthday');
        $civilstatus=$req->input('civilstatus');
        $nationality=$req->input('nationality');
        $religion=$req->input('religion');
        $children=$req->input('children');
        $hired_date=$req->input('hired_date');
        

        // return $req;

        If($action == "DELETE"){     
         
        Employee::where('company_code' , $params_company)
            ->where('employee_code'  , $employee_code)
            ->update(['deleted_at' => date('Y-m-d H:i:s') , 
                'updated_at' =>  date('Y-m-d H:i:s') , 
                'updated_by' => '00005' ]);
            return $this->get_data(); 
        }
        else{


            $exists=Employee::from('employees as emp')
                        ->select('emp.company_code' , 
                                    'emp.department_code' ,
                                    'emp.section_code' , 
                                    'emp.employee_name')
                        ->where('emp.company_code' , '=' , $params_company)
                        ->where('emp.department_code' , '=' , $params_department)
                        ->where('emp.section_code' , '=' ,$params_section)
                        ->where('emp.employee_name' , '=' , $employee_name)
                        ->get();

return view('welcome');


          if( $params_company == '' ||  $params_department ==''  || $params_section == '' 
          ||  $employee_name == ''   ||  $status =='' ){
            // return $req;
            return   'blank';
           }

          elseif ( $params_company != '' 
          && $params_department != ''    &&  $params_section != '' 
          &&  $employee_name != ''   &&    $gender != ''  && $status != '')   {

            $maxEmp=Employee::from('employees as emp')
                     ->select(DB::raw('emp.employee_code + 1 as new_EmpCode'))
                    ->orderby('emp.employee_code' , 'desc')
                    ->limit(1)
                    ->get();

                //   return   $maxEmp  ;

            $new_Empcode=str_pad(count($maxEmp)  > 0 ?   $maxEmp[0] ->new_EmpCode: '1' , 3 , '0' , STR_PAD_LEFT); 

          

              if($action == "ADD" && count($exists)==0 ) {
                   
                // $new_Empcode=str_pad(count($maxEmp)  > 0 ?   $maxEmp[0] ->new_Empcode: '1' , 3 , '0' , STR_PAD_LEFT); 

                // return  $new_Empcode;
               



                    Employee::Insert([
                                    'company_code'=>$params_company , 
                                    'department_code'=> $params_department  ,
                                    'section_code'=>   $params_section , 
                                    'employee_code'=>$new_Empcode,
                                    'employee_name' =>strtoupper($employee_name), 
                                    'gender' =>$gender, 
                                    'age'=>$age,
                                    'civilstatus'=>$civilstatus,
                                    'birthday'=> $bday,
                                    'religion'=>$religion,
                                    'nationality'=>$nationality,
                                    'children'=>$children,
                                    'contract_status' =>strtoupper($status), 
                                    'hired_date'=> $hired_date,
                                    'created_at'=>date('Y-m-d H:i:s') , 
                                    'updated_at' =>date('Y-m-d H:i:s') ,
                                    'updated_by' =>'00005']);
                
                employee_contact::insert([
                        'employee_code'=>$new_Empcode,
                        'cp_no'=> $req->input('cp_no'), 
                        'tel_no'=> $req->input('tel_no'), 
                        'address'=> $req->input('address'), 
                        'contact_person'=> $req->input('contact_person'), 
                        'con_cpno'=> $req->input('con_cpno'), 
                        'email'=> $req->input('email')
                ]);
                

                }elseif($action == "UPDATE") {
                    
                        Employee::
                                where('employee_code' , $employee_code)
                                ->update(['company_code' =>$params_company, 
                                        'department_code' => $params_department,
                                        'section_code' => $params_section,
                                        'employee_name' => $employee_name,
                                        'age'=>$age,
                                        'civilstatus'=>$civilstatus,
                                        'birthday'=> $bday,
                                        'religion'=>$religion,
                                        'nationality'=>$nationality,
                                        'children'=>$children,
                                        'gender' => $gender, 
                                        'contract_status' =>$status, 
                                        'retired_date' => $req->input('retired_date'), 
                                        'updated_at' =>date('Y-m-d H:i:s') ,
                                        'updated_by' =>'00005']);   


                        employee_contact::where('employee_code' , $employee_code)
                        ->update([
                            'employee_code'=>$new_Empcode,
                            'cp_no'=> $req->input('cp_no'), 
                            'tel_no'=> $req->input('tel_no'), 
                            'address'=> $req->input('address'), 
                            'contact_person'=> $req->input('contact_person'), 
                            'con_cpno'=> $req->input('con_cpno'), 
                            'email'=> $req->input('email')
                    ]);

                }


                return $this->get_data(); 

            }
        
       elseif(count($exists)==1 && $action == "ADD"  ){
         return 'exist';}
            
            
        }
   
    }
  
}
