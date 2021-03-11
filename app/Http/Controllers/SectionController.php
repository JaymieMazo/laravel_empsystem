<?php

namespace App\Http\Controllers;
use App\Company;
use App\Department;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
class SectionController extends Controller
{

    public function get_data(){
    $items=[];
      
    $items["Company"]=Company::where('deleted_at' , null)->get();

    $items["Department"]=Department::where('deleted_at' , null)->get();

    $items["Section"]=Section::from('sections as sec')
            ->select(
                'sec.company_code' , 
                'com.company_name' ,
                'sec.department_code' ,
                'dep.department_name' , 
                 'sec.section_code', 
                'sec.section_name',
               'sec.created_at' , 
               'sec.deleted_at',
              'sec.updated_at' , 
              'emp.employee_name') 
            ->join('companies as com' , 'sec.company_code' ,'=',  'com.company_code')
            ->join('departments as dep' ,function($join){
                $join->on('sec.company_code' , '='  , 'dep.company_code');
                $join->on('sec.department_code' , '=' ,'dep.department_code');
            })
            ->join('employees as emp' , 'sec.updated_by' , '=' , 'emp.employee_code')
            ->where('com.deleted_at' , null)
            ->where('dep.deleted_at' , null)
            ->where('sec.deleted_at' , null)
            ->get();
        // return view('section' , compact('company' , 'dept', 'sections' ));
        return   ($items);
    }

    public function insert_data(Request $req){
        $action=$req->input('action');
        $params_company=$req->input('company_code' );
        $params_department=$req->input('department_code' );
        $params_section_name=$req->input('section_name' );
        $company_code_orig=$req->input('company_code_orig' );
        $created_at=$req->input('created_at' );
        $updated_at=$req->input('updated_at' );

        
        $department_code_orig=$req->input('department_code_orig' );
        $section_code=$req->input('section_code' );



        // return    $req;
        If($action == "DELETE"){       
            $delete=Section::where('company_code' , $params_company)
            ->where('department_code' , $params_department)
            ->where('section_code' , $section_code)
            ->update(['deleted_at' => date('Y-m-d H:i:s') , 
                'updated_at' =>  date('Y-m-d H:i:s') , 
                'updated_by' => '00005'
]);
            return $this->get_data(); 
        }else{
            $exists=section::select('sections.company_code' , 'sections.department_code' , 'section_name'  )
            ->join('departments' ,function($join){
                $join->on('sections.company_code' , '='  , 'departments.company_code');
                $join->on('sections.department_code' , '='  , 'departments.department_code');
            })
            ->where('sections.company_code' , '=' , $params_company)
            ->where('sections.department_code' , '=' , $params_department)
            ->where('section_name' , '=' ,$params_section_name)
            ->get();

          if( $params_section_name =='' ||  $params_company == '' ||  $params_department ==''  ){
            return   'blank';
           }
          elseif (count($exists)==0 &&  $params_section_name !='' ) {
            
            $maxSec=section::select(DB::raw('section_code + 1 as new_SecCode'))
                    ->join('departments' ,function($join){
                            $join->on('sections.company_code' , '='  , 'departments.company_code');
                            $join->on('sections.department_code' , '='  , 'departments.department_code');
                        })
                    ->where('sections.company_code' , '=' , $params_company)
                    ->where('sections.department_code' , '=' , $params_department)
                    ->orderby('section_code' , 'desc')
                    ->limit(1)
                    ->get();

            $new_sectioncode=str_pad(count($maxSec)  > 0 ?   $maxSec[0] ->new_SecCode: '1' , 3 , '0' , STR_PAD_LEFT); 
          
              if($action == "ADD"){
                    $new_sectioncode=str_pad(count($maxSec)  > 0 ?   $maxSec[0] ->new_SecCode: '1' , 3 , '0' , STR_PAD_LEFT); 
                    Section::Insert([
                        'company_code'=>$params_company , 
                    'department_code'=> $params_department  ,
                        'section_code'=>   $new_sectioncode , 
                        'section_name' =>strtoupper($params_section_name), 
                        'created_at'=>date('Y-m-d H:i:s') , 
                        'updated_at' =>date('Y-m-d H:i:s') ,
                        'updated_by' =>'00005']);
                }elseif($action == "UPDATE") {

                        if($params_company != $company_code_orig || $params_department != $department_code_orig){
                    
                    
                     Section::where('company_code' , $company_code_orig)
                            ->where('department_code' , $department_code_orig)
                            ->where('section_code' , $section_code)
                            ->delete();   


                      Section::Insert([
                                'company_code'=>$params_company , 
                                'department_code'=> $params_department  ,
                                'section_code'=>   $new_sectioncode , 
                                'section_name' =>strtoupper($params_section_name), 
                                'created_at'=>date('Y-m-d H:i:s') , 
                                'updated_at' =>date('Y-m-d H:i:s') ,
                                'updated_by' =>'00005']);
                                
                        }else if($params_company == $company_code_orig 
                        && $params_department == $department_code_orig  ){
                           

                       
                        Section::where('company_code' ,$company_code_orig )
                                            ->where('department_code' , $department_code_orig)
                                            ->where('section_code' , $section_code)
                                            ->update(['section_name' => $params_section_name,
                                                        'updated_at' =>date('Y-m-d H:i:s') ,
                                                        'updated_by' =>'00005' 
                                            ]);   
                        }   
                }

                return $this->get_data(); 
            }
            elseif(count($exists)==1){
                return 'exist';
            }
            // return Redirect::back();
            }
        }
   
    
  
}
