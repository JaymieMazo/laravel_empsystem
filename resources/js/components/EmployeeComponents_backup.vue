<template>
<v-card>
        <v-row  class="pa-2" >
                <v-col cols=2>
                        <v-select 
                                  v-model="company_code"
                                  :items="companies"
                                  item-text="company_name"
                                  item-value="company_code"
                                  label="Select Company">
                          </v-select>
            
                  </v-col >

                    <v-col  cols=4>
                        <v-select
                          v-model="department_code"
                                 :items="filteredDept"
                                  item-text="department_name"
                                  item-value="department_code"
                                  label="Select Department" >
                          </v-select>
                  </v-col>

                 <v-col  cols=3>
                        <v-select
                          v-model="section_code"
                                 :items="filteredSection"
                                  item-text="section_name"
                                  item-value="section_code"
                                  label="Select Section" >
                          </v-select>
                  </v-col>


                  <v-btn>
                  <v-icon>mdi-plus-circle</v-icon>
                  </v-btn>

</v-row> 

<v-row class="pa-2">

        <v-col  cols=3>
            <v-select
              v-model="gender"
                 :items="genderList" 
               item-text="name"
               item-value="id"
              label="Select Gender">
              </v-select>
        </v-col>


        <v-col cols=3 >
                <v-select
                    v-model="status"
                    :items="statusList"
                    item-text="name"
                    item-value="id"
                    label="Select Contract Status" >
              </v-select>
      </v-col>

         <v-col cols=5>
                    <v-text-field
                      label="Enter Employee Name"
                      v-model="employee_name"
                      >
                    </v-text-field>
          </v-col>

</v-row>


<v-simple-table >
      
        <template v-slot:default>
              <thead >
                <tr >
                    <th class="text-left">No </th>
                    <th class="text-left">Employee Name </th>
                     <th class="text-left">Gender </th>  
                  <th class="text-left">Contract Status</th>  
                  <th class="text-left">Company </th>
                  <th class="text-left">Department</th>  
                  <th class="text-left">Section</th>  
                  
                  <th>Action</th>
                </tr>
              </thead>

                <tbody>
                      <tr
                        v-for="(item, index)  in employees"  
                        :key="index"
                      >
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.employee_name }}</td>
                               <td>{{ item.gender_name }}</td>
                             <td>{{ item.contract_status }}</td>
                            <td>{{ item.company_name }}</td>
                            <td>{{ item.department_name }}</td>
                             <td>{{ item.section_name }}</td>
                             
                          
                          <td>
                                    <v-btn icon>
                                        <v-icon  
                                              color="primary lighten-2"
                                              @click="edit(
                                              item.company_code,
                                              item.department_code, 
                                              item.section_code,  
                                              item.employee_code,  
                                              item.employee_name, 
                                              item.gender, 
                                              item.contract_status
                                                )"
                                              >mdi-book-edit
                                        </v-icon>

                                    </v-btn>

                                  <v-btn icon>
                                          <v-icon
                                      
                                          color="red lighten-2"
                                            @click="Delete(
                                              item.company_code,
                                              item.department_code,
                                              item.section_code)"
                                          >
                                            mdi-trash-can
                                          </v-icon>
                                  </v-btn>

                <v-menu transition="slide-x-transition">
                              <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                icon
                                  color="primary"
                                  class="ma-2"
                                  v-bind="attrs"
                                  v-on="on"
                                >
                                <v-icon>mdi-account-box-multiple</v-icon>
                                </v-btn>
                              </template>

                               <v-card style="height:300px">
                                 <v-card-title class="cyan darken-1">
                                   <span class="headline white--text"> {{item.employee_name}}</span>
                                           </v-card-title>
                                 <v-list > 
                                      <v-list-item  >
                                            <v-list-item-action>
                                              <v-icon>mdi-phone</v-icon>
                                            </v-list-item-action>

                                            <v-list-item-content> 
                                                  <v-list-item-title>{{item.tel_no}}</v-list-item-title>
                                            </v-list-item-content>

                                             <v-list-item-action>
                                          <v-icon>mdi-message</v-icon>
                                        </v-list-item-action>
                                      </v-list-item>

                                  
                                    <v-divider inset></v-divider>


                                <v-list-item  >
                                            <v-list-item-action>
                                              <v-icon>mdi-email</v-icon>
                                            </v-list-item-action>

                                            <v-list-item-content> 
                                                  <v-list-item-title>{{item.email}}</v-list-item-title>
                                            </v-list-item-content>
                                      </v-list-item>
            <v-divider inset></v-divider>
                                              <v-list-item  > 
                                            <v-list-item-action>
                                              <v-icon>mdi-map-marker</v-icon>
                                            </v-list-item-action>

                                            <v-list-item-content> 
                                                  <v-list-item-title>{{item.address}} </v-list-item-title>
                                            </v-list-item-content>

                                            
                                      </v-list-item>
                                 </v-list>
                                    <v-spacer></v-spacer>
          </v-card>

       </v-menu>
                          
    </td>
 
</tr>
 </tbody>

</template>

      </v-simple-table>   
</v-card>
</template>


<script>
export default {
				data(){
				        return{
				            companies:[],
                    departments:[],
                    sections:[],
                    employees:[],
                    genderList:[{id:1 , name:'Male'} , {id:0 , name:'Female'}],
                    statusList:[ {id:'C' , name:'Contractual'} , {id:'R' , name: 'Regular'}],
                    //field variables
				            company_code: null,
                    department_code:null, 
                    section_code_orig:null,
                    gender:null , 
                    status:null , 
                    employee_code:null, 
                    employee_name:null, 
                    action:'ADD', 
                    IsCancelShow:false, 
                    created_at:null,
                    updated_at:null,
                    // edit primary key
                    company_code_orig: null, 
                    department_code_orig: null, 
                    section_code:null, 
                   
                  
                    dialog:false,
				        } 
				}, 



				created(){
				        axios.get('api/home' ).then(res=>{
                      this.companies= res.data.Company
                      this.departments=res.data.Department
                      this.sections=res.data.Section
                      this.employees=res.data.Employee
                })
                

				},




      computed:{
        filteredDept(){
          return this.departments.filter(rec=>{
                return rec.company_code == this.company_code 
          })
        }, 



          filteredSection(){
          return this.sections.filter(rec=>{
                return rec.company_code == this.company_code 
                 && rec.department_code ==this.department_code
          })
        }
      }, 



			  methods:{
			      save(){
					        axios.post('api/home' , 
					        {action: this.action ,
                    company_code:  this.company_code ,
                    department_code: this.department_code , 
                    section_code: this.section_code , 
                    employee_code:this.employee_code,
                    employee_name:this.employee_name,
                    gender:this.gender,
                    status:this.status,
                    company_code_orig:this.company_code_orig , 
                    department_code_orig:this.department_code_orig,
                    section_code_orig:this.section_code_orig
					            }).then(res=> {
                            console.log(res.data)
					                  if(res.data=='blank'){
					                      alert('Please Fill up all fields!')
					                  }else if(res.data == 'exist'){
					                      alert('Employee already exist')
					                  }else{
                              alert('refresh')
					                      this.employees=res.data.Employee
					                  }
                      })

                   this.Cancel();
                }, 
      
			      edit(com_code , dep_code, sec_code, emp_code,  emp_name , gender , status){
                  this.action='UPDATE'
                  this.IsCancelShow=true
      
                    this.company_code=com_code
                    this.department_code=dep_code
                    this.section_code=sec_code

                    this.company_code_orig=com_code
                    this.department_code_orig=dep_code
                    this.section_code_orig=sec_code
                    this.employee_code =emp_code
                    this.employee_name =emp_name
 
                    this.gender=gender
                    this.status=status
			      },
            

			      Cancel(){
			          this.IsCancelShow=false
                this.action='ADD'
                this.company_code=''
                this.department_code=''
                this.section_code=''
                this.employee_name=''
                this.gender=''
                this.status=''
			      }, 
      
      
			       Delete(companyCode, deptcode , secCode ){
                        if(confirm('Are you sure you want to delete? ')){
                                  this.action="DELETE"
                                  axios.post('api/section' ,
                                            {action: this.action, 
                                            company_code:companyCode, 
                                            department_code : deptcode,
                                            section_code : secCode
                                }).then(res=>{
                                      this.sections=res.data.Section
                                      })
                      }  
            }, 
            

  				}, 
  }
</script>



