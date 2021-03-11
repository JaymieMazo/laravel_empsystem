<template>
<v-card>
<template>
     <v-dialog v-model="dialog1"
        width="72%"
    >
          <template v-slot:activator="{on , attrs}" >
              <v-btn    v-bind="attrs"   
                        v-on="on" 
                        fab 
                        dark 
                        small
                         class="mx-2"
                         
                         @click="edit(null)">
                    <v-icon>mdi-plus</v-icon>      
              </v-btn>
          </template>
        <v-card class="rounded-xl">
        <v-card-title  
         style="font-family:cursive ; font-size:30px"
              class="text-center justify-center py-6 teal lighten-4"
           >{{this.tab_head}}
        </v-card-title >
        <v-card-text>
         <v-tabs   v-model="tab" color="basil" background-color="transparent" >
              <v-tab  v-for="(item, key) in itemTabs" :key="key" @change="tab_change(key)" 
              style="font-family:cambria ; font-size:15px">
             <b>   {{item}} </b>  
              </v-tab>

              <v-tabs-items  v-model="tab" >
                  <v-tab-item>
                        <v-row>
                              <v-col cols=5>
                                        <v-text-field
                                   
                                          label="Enter Employee Name"
                                          v-model="editvar.employee_name"
                 
                                          >
                                        </v-text-field>
                              </v-col>
                              <v-col cols=2>
                                          <v-text-field
                                           type="number"
                                            label="Enter Age"
                                            v-model="editvar.age"
                                       
                                            >
                                          </v-text-field>
                              </v-col>

                              <v-col cols=2>
                                        <!-- <v-text-field
                                          label="Enter Birthday"
                                          v-model="editvar.birthday"
                                         
                                          >
                                        </v-text-field> -->


                                        <v-menu
                                        v-model="menu2"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="auto"
                                      >
                                        <template v-slot:activator="{ on, attrs }">
                                          <v-text-field
                                                v-model="editvar.birthday"
                                                label="Birthday"
                                                prepend-icon="mdi-calendar"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                          ></v-text-field>

                                        </template>
                                       
                                        <v-date-picker
                                          v-model="editvar.birthday"
                                          @input="menu2 = false"
                                        ></v-date-picker>
      </v-menu>
                            </v-col>
                            <v-col  cols=2>
                                  <v-select
                                          v-model="editvar.gender"
                                          :items="genderList" 
                                          item-text="name"
                                          item-value="id"
                                          label="Select Gender"
                                          >

                                    </v-select>
                            </v-col>

                        </v-row>

                        <v-row>
                              <v-col cols=3>
                                        <v-select  v-model="editvar.civilstatus"
                                        label="Enter Civil Status" 
                                        :items="civilStat"
                                        
                                      
                                        >
                                        </v-select>
                                      </v-col>



                                <v-col cols=3>
                                    <v-text-field label="Nationality"
                                     v-model="editvar.nationality"
                                    required></v-text-field>
                                </v-col>
                                <v-col cols=3>
                                      <v-text-field label="Religion" 
                                      v-model="editvar.religion"
                                      required>
                                      </v-text-field>
                                </v-col>

                                <v-col cols=2>
                                      <v-text-field label="No. of Children" 
                                      v-model="editvar.children"
                                      required></v-text-field>
                                </v-col>
                        </v-row>

                        </v-tab-item>

                          <v-tab-item>
                                    <v-row >
                                      <v-col cols=3>
                                            <v-text-field label="Enter Cellphone No." 
                                            v-model="editvar.cp_no"
                                            required ></v-text-field>
                                      </v-col> 

                                        <v-col cols=3>
                                            <v-text-field  label="Enter Telephone No."
                                            v-model="editvar.tel_no"
                                            required ></v-text-field>
                                      </v-col>

                                      
                                        <v-col cols=4>
                                            <v-text-field label="Enter email No "
                                             v-model="editvar.email"
                                             required></v-text-field>
                                      </v-col>
                                    </v-row>
                                      <v-row >
                                      <v-col cols=3>
                                            <v-text-field label="Enter  present  Address" 
                                              v-model="editvar.address"
                                              required></v-text-field>
                                      </v-col> 
                                        <v-col cols=3>
                                            <v-text-field label="Enter Contact Person"
                                            v-model="editvar.contact_person"
                                            required></v-text-field>
                                      </v-col>

                                      
                                        <v-col cols=4>
                                            <v-text-field label="Enter  Contact Person CP No.   " 
                                            v-model="editvar.con_cpno"
                                            required></v-text-field>
                                      </v-col>
                              </v-row>
                  </v-tab-item>

                    <v-tab-item>
                          <v-row>
                                <v-col cols="3">
                                      <v-select
                                                v-model="editvar.company_code"
                                                    :items="companies"
                                                    item-text="company_name"
                                                    item-value="company_code"
                                                    label="select Company "
                                                    required>
                                      </v-select>
                                </v-col>
                                <v-col cols="4">
                                    <v-select
                                        v-model="editvar.department_code"
                                        :items="filteredDept"
                                        item-text="department_name"
                                        item-value="department_code"
                                        label="select Department"
                                        required>

                                    </v-select>
                                </v-col>
                                <v-col cols="4"> 
                                    <v-select v-model="editvar.section_code"
                                              :items="filteredSection"
                                              item-text="section_name"
                                              item-value="section_code"
                                              label="select Section "
                                              required
                                      >
                                    </v-select>
                                </v-col>
                                </v-row>
                        <v-row> 
                                <v-col cols=3 >
                                        <v-select
                                            v-model="editvar.contract_status"
                                            :items="statusList"
                                            item-text="name"
                                            item-value="id"
                                            label="Select Contract Status" >
                                      </v-select>
                              </v-col>
                            <v-col cols=3>
                                <!-- <v-text-field label="Enter Hired Date"
                                v-model="editvar.hired_date"></v-text-field> -->


                                  <v-menu
                                        v-model="menu3"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="auto"
                                      >
                                        <template v-slot:activator="{ on, attrs }">
                                          <v-text-field
                                                v-model="editvar.hired_date"
                                                label="Hired Date"
                                                prepend-icon="mdi-calendar"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                          ></v-text-field>

                                        </template>
                                       
                                        <v-date-picker
                                          v-model="editvar.hired_date"
                                          @input="menu3 = false"
                                        ></v-date-picker>
      </v-menu>
                            </v-col>


                            <v-col cols=3>
                                <!-- <v-text-field label="Enter Retired Date"
                                v-model="editvar.retired_date"></v-text-field> -->


                                <v-menu
                                        v-model="menu4"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="auto"
                                      >
                                        <template v-slot:activator="{ on, attrs }">
                                          <v-text-field
                                                v-model="editvar.retired_date"
                                                label="Retired Date"
                                                prepend-icon="mdi-calendar"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                          ></v-text-field>

                                        </template>
                                       
                                        <v-date-picker
                                          v-model="editvar.retired_date"
                                          @input="menu4 = false"
                                        ></v-date-picker>
      </v-menu>
                            </v-col>
                                
                            </v-row>
                          </v-tab-item>
                          <v-btn @click="save()" color="primary">Save</v-btn>
               </v-tabs-items>   
                </v-tabs>
        </v-card-text>
        </v-card>
        </v-dialog>
        </template>




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
                                              @click="edit(index),dialog1 = !dialog1 "
                                              >mdi-book-edit
                                        </v-icon>
                                    </v-btn>
                                  <v-btn icon>
                                          <v-icon
                                      
                                          color="red lighten-2"
                                            @click="Delete(
                                              index)"
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
                // date: new Date().toISOString().substr(0, 10),
                  menu: false,
                  menu2: false,
                  menu3:false,
                  menu4:false,
				            companies:[],
                    departments:[],
                    sections:[],
                    employees:[],
                    genderList:[{id:1 , name:'Male'} , {id:0 , name:'Female'}],
                    statusList:[ {id:'C' , name:'Contractual'} , {id:'R' , name: 'Regular'}],
                    itemTabs:['Personal Information' , 'Contact Information' , 'Employment Information'], 
                    civilStat:['Single' , 'Married'],
                    employee_code:null, 
                    IsCancelShow:false, 
                    dialog1:false,
                    tab:0,
                    tab_head:'Personal Information',
                    editvar:{},
                    addvar:{ action:'ADD' , employee_name:null, gender:null ,       contract_status:null, age:null , birthday:null ,  civilstatus: null, nationality:null , religion:null ,  children:null , company_code:null, 
                    department_code:null , section_code:null , hired_date: null , retired_date:null 
                              },
				        } 
				}, 



				created(){
				        axios.get('api/employee' ).then(res=>{
                      this.companies= res.data.Company
                      this.departments=res.data.Department
                      this.sections=res.data.Section
                      this.employees=res.data.Employee
                })
				},



      computed:{
        filteredDept(){
          return this.departments.filter(rec=>{
                return rec.company_code == this.editvar.company_code 
          })
        }, 



          filteredSection(){
          return this.sections.filter(rec=>{
                return rec.company_code == this.editvar.company_code    && rec.department_code == this.editvar.department_code
          })
        },


        editEmployee(){
          return this.employees.filter(rec=> {
            return rec.employee_code==this.employee_code
          })
          
        }, 


      checkValidation:function(){
              return jQuery.isEmptyObject(this.editvar)
           }, 
      }, 


      watch:{}, 
			methods:{   
			      save(){
					        axios.post('api/employee' ,this.editvar
                  ).then(res=> {
                            console.log(res.data)
					                  if(res.data=='blank'){
					                      alert('Please Fill up all fields!')
					                  }else if(res.data == 'exist'){
					                      alert('Employee already exist')
					                  }else{
                              // alert('refresh')
					                      this.employees=res.data.Employee
					                  }
                      })
                   this.Cancel();
                }, 
      
			  
                edit(index){   
                  if(index==null){
                    this.editvar=this.addvar
                  }else{
                    
                 this.IsCancelShow=true
                 this.editvar = JSON.parse(JSON.stringify(this.employees[index]))
                 Vue.set(this.editvar, "company_code_orig", this.editvar.company_code)
                 Vue.set(this.editvar, "department_code_orig",this.editvar.department_code)
                 Vue.set(this.editvar, "section_code_orig", this.editvar.section_code)
                 Vue.set(this.editvar, "action", 'UPDATE')
                 }      
			      },
        


			      Cancel(){
			          this.IsCancelShow=false
			      }, 
            
			       Delete(index){
                        if(confirm('Are you sure you want to delete? ')){
                             this.editvar = JSON.parse(JSON.stringify(this.employees[index]))
                        Vue.set(this.editvar, "action", 'DELETE')
                        console.log(this.editvar)
                         axios.post('api/employee' ,this.editvar).then(res=>{
                                    
                                        this.employees=res.data.Employee
                                      })
                      }  
            }, 

             
            tab_change(key){
                if(key==0){
                  this.tab_head="Personal Information"
                }else if(key==1){
                    this.tab_head="Contact Information"
                }else if(key==2){
                    this.tab_head="Personal Information"
                }
            }
  				}, 
  }
</script>
<style >
.rounded{
  border-radius:500px;
}
</style>