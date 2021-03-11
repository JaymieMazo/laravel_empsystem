<template>
<v-card>
        
        <v-row  class="pa-2" >
                <v-col cols="5" >
                        <v-select
                                  v-model="company_code"
                                  :items="companies"
                                  item-text="company_name"
                                  item-value="company_code"
                                  label="Select Company">
                          </v-select>
            
                  </v-col>
                <v-col>
                        <v-text-field
                          label="Enter Department Name"
                          v-model="department_name_input"
                         >
                        </v-text-field>
                  </v-col>


                <v-col >
                      <v-btn 
                      type="submit"
                      color="primary lighten-1" 
                        @click="save()"  
                        dense>
                              {{this.action}} 
                        </v-btn>

                        <v-btn 
                        color="primary lighten-1" 
                        @click="Cancel() " 
                        dense
                        v-show="this.IsCancelShow"> Cancel 
                        </v-btn>
                </v-col>
        </v-row>


      <v-simple-table >
        <template v-slot:default>

              <thead >
                <tr >
                    <th class="text-left">No </th>
                  <th class="text-left">Company </th>
                  <th class="text-left">Department</th>  
                  <th class="text-left">Created Date</th>
               
                   <th class="text-left">Deleted Date</th>
                      <th class="text-left">Updated Date</th>
                  <th class="text-left">Updated By</th>
                  <th>Action</th>
                </tr>
              </thead>

                <tbody>
                      <tr
                        v-for="(item, index)  in dept"  
                        :key="index"
                      >
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.company_name }}</td>
                            <td>{{ item.department_name }}</td>
                            <td>{{ item.created_at }}</td>
                            <td>{{ item.deleted_at }}</td>
                            <td>{{ item.updated_at }}</td> 
                          <td>{{ item.employee_name }}</td>
                          <td>
                                    <v-btn icon>

                                        <v-icon  
                                              class="ma-2" 
                                              color="primary lighten-2"
                                              @click="edit(item. company_code, item.department_name , item.department_code)"
                                              >mdi-book-edit
                                        </v-icon>

                                    </v-btn>

                                  <v-btn icon>
                                          <v-icon
                                          class="ma-2"   
                                          color="red lighten-2"
                                            @click="Delete(item.company_code,item.department_code)"
                                          >
                                            mdi-trash-can
                                          </v-icon>
                                  </v-btn>
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
				            department_sel:[],
				            company_code: null,
				            department_code:null, 
				            department_name_input:null,
				            action:'ADD', 
				            company_code_orig: null, 
				            IsCancelShow:false, 
				        } 
				}, 
				created(){
				        axios.get('api/department' ).then(res=>{
				              this.companies= res.data.Company
				              this.departments=res.data.Department
				        })
				},

        computed:{
              dept(){
       
                if(this.company_code == null  ||  this.company_code == ''){
                  
                  return this.departments
                }else{
                     return this.departments.filter(
                  rec=> {
                    return  rec.company_code == this.company_code
                  }
                )
                }
             
              }
        },
			  methods:{
			  
			      save(){
					        axios.post('api/department' , 
					        {action: this.action ,
					         company_code:  this.company_code , 
					          department_name: this.department_name_input  ,
					           company_code_orig:this.company_code_orig , 
					           department_code: this.department_code
					            }).then(res=> {
					                    
					                  if(res.data=='blank'){
					                      alert('Company and Department Name are required ')
					                  }else if(res.data == 'exist'){
					                      alert('Department already existed')
					                  }else{
                              // alert('refresh')
					                      this.departments=res.data.Department
					                  }
                      })
                             
                } 
                , 
			
			      edit(com_code , dep_name , dep_code){
						        this.action='UPDATE'
						        this.IsCancelShow=true
						        this.company_code=com_code
						        this.department_name_input=dep_name
						        this.company_code_orig=com_code
						        this.department_code=dep_code
			
			      },
			      
			
			      Cancel(){
			          this.company_code=''
			          this.department_name_input =''
			          this.IsCancelShow=false
			          this.action='ADD'
			      }, 
      
    
			       Delete(companyCode, deptcode){
                    if(confirm('Are you sure you want to delete? ')){
                              this.action="DELETE"
                              axios.post('api/department' ,
                                        {action: this.action, 
                                        company_code:companyCode, 
                                        department_code : deptcode
                            }).then(res=>{
                                  this.departments=res.data.Department
                                  })
                    
                }  
			            
			
			  		}

  				}, 
  }
</script>


