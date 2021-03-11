<?php

Namespace App\Http\Controllers;
use Illuminate\Http\Request;
Use App\Company;
Use App\Department;
Use App\Section;
Use App\Employee;
Use App\User;


class HomeController extends Controller
{   
            public function get_data(){
                $items=[];
                $items["Company"]= Company::where('deleted_at' ,  null)->count();
                $items["Department"]= Department::where('deleted_at' ,null)->count();
                $items["Section"]= Section::where('deleted_at' ,null)->count();
                $items["Employee"]= Employee::where('deleted_at' , null)->count();
                $items["User"]= User::where('deleted_at' , null)->count();
                $items["Admin"]= User::where('deleted_at' , null)->count();
                $items["Allemp"]=Employee::count();
    
                $items["Months"]= [];
                $name='';

                            for ($x = 1; $x <= 12; $x+=1) {
                                    $data= employee::whereyear('Retired_Date', '2020')
                                                ->wheremonth('Retired_Date', $x)
                                                ->count() ;


                                                if($x ==1){$name="Jan"; }
                                                elseif($x ==2){$name="Feb"; }
                                                elseif($x ==3){$name="Mar"; }
                                                elseif($x ==4){$name="Apr"; }
                                                elseif($x ==5){$name="May"; }
                                                elseif($x ==6){$name="June"; }
                                                elseif($x ==7){$name="July"; }
                                                elseif($x ==8){$name="Aug"; }
                                                elseif($x ==9){$name="Sep"; }
                                                elseif($x ==10){$name="Oct"; }
                                                elseif($x ==11){$name="Nov"; }
                                                elseif($x ==12){$name="Dec"; }

                                                array_push($items["Months"], (object)[
                                                    'name' => $name,
                                                     'y' =>$data 
                                                    ]);

                                                // array_push($items["Months"] , $data);
                            };

                      

                    
                        return  $items;
        
            }


                public function retrieve_data(Request $req){
                        
                }
}
