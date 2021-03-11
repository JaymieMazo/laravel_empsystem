<?php

Namespace App\Http\Controllers;
use Illuminate\Http\Request;
Use App\Company;
Use App\Department;
Use App\Section;
Use App\Employee;


class JunksController extends Controller
{   
    public function get_data(){
        $items=[];
        $items["cntCompany"]= Company::where('deleted_at' , '<>' , 'null')->count();
        $items["cntDepartment"]= Department::where('deleted_at' , '<>' , 'null')->count();
        $items["cntSection"]= Section::where('deleted_at' , '<>' , 'null')->count();
        $items["cntEmployee"]= Employee::where('deleted_at' , '<>' , 'null')->count();

        $items["Company"]= Company::where('deleted_at' , '<>' , 'null')->get();
        $items["Department"]= Department::where('deleted_at' , '<>' , 'null')->get();
        $items["Section"]= Section::where('deleted_at' , '<>' , 'null')->get();
        $items["Employee"]= Employee::where('deleted_at' , '<>' , 'null')->get();
       
        return  $items;

        
    }





    public function retrieve_data(Request $req){
        $id=$req->input("id");
        $category=$req->input("category");

        if( $category == 'Company'){
                    Company::wherein('company_code' ,  $id)
                                ->update(['deleted_at' => null , 
                                            'updated_by' => '00005']);                               
        }

        else if ($category == 'Department'){
            department::wherein('department_code' ,$id )
            ->update(['deleted_at' => null , 
                        'updated_by' => '00005']);
        }

        else if ($category == 'Section'){
            section::wherein('section_code' ,$id )
            ->update(['deleted_at' => null , 
                        'updated_by' => '00005']);
            
        }

        else if ($category == 'Employee'){
            employee::wherein('employee_code' ,$id )
            ->update(['deleted_at' => null , 
                        'updated_by' => '00005']);
            
        }

        return $this->get_data();
    }
}
