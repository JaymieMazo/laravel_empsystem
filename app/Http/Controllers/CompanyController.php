<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
Use App\Company;

class CompanyController extends Controller
{
    public function get_data(){
        $data=Company::from('companies as Com')
            ->select( 'Com.company_code' , 
                'Com.company_name' ,
                'Com.created_at' ,
                'Com.deleted_at',
                'Com.updated_at' , 
                'emp.employee_name' , 
                )

        ->join('employees as emp' , 'Com.updated_by', '=','emp.employee_code')
        ->where('Com.deleted_at' , null)
        ->get();

    return $data;

    } 

    public function insert_data(Request  $req){
    $isAction=  $req->input('IsAction');
    $company_code=$req->input('company_code');

        $params_name=$req->input('company_name');
        $if_exist=Company::select('company_name')
       ->where('company_name' , strtoupper($params_name))
       ->get();

        if($isAction=='ADD'){
                        if(count($if_exist ) == 0 && $params_name != ''){
                            $last_code=Company::select(Company::raw('company_code + 1  as new_code' ) )
                            ->orderby('company_code' , 'desc')
                            ->limit(1)
                            ->get();
                            $new_id=str_pad(count($last_code)  > 0 ?   $last_code[0] ->new_code: '1' , 3 , '0' , STR_PAD_LEFT); 
                            Company::Insert(['company_code' =>$new_id,
                             'company_name' =>strtoupper($params_name), 
                             'created_at'=>date('Y-m-d H:i:s') ,
                            'updated_at' =>date('Y-m-d H:i:s') ,
                             'updated_by' =>'00005']);
                           
                            return $this->get_data();
                        }
                    elseif(count($if_exist ) <> 0   && $params_name != ''){
                            return 'exist';
                          
                    }
                    elseif(count($if_exist ) ==0 && $params_name == ''){
                        return 'blank';
                    }
        }elseif($isAction == 'UPDATE'){
            $update_company=Company::where('company_code' ,   $company_code)
            ->update(['company_name' => $params_name,
            'updated_at' =>date('Y-m-d H:i:s') ,
            'updated_by' =>'00005' ]);

            return   $this->get_data();
        }
        elseif($isAction == 'DELETED'){
                $delete_company=Company::where('company_code' , $company_code)
                                ->update([
                                    'deleted_at' => date('Y-m-d H:i:s'), 
                                    'updated_at' =>  date('Y-m-d H:i:s') , 
                                    'updated_by' => '00005'
                                ]);
        return   $this->get_data();
        }
           
      
      
    }


}
