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
                          label="Enter position Name"
                          v-model="position_name_input"
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
                  <th class="text-left">position</th>  
                  <th class="text-left">Created Date</th>
               
                   <th class="text-left">Deleted Date</th>
                      <th class="text-left">Updated Date</th>
                  <th class="text-left">Updated By</th>
                  <th>Action</th>
                </tr>
              </thead>


                <tbody>
                      <tr
                        v-for="(item, index)  in filterpos"  
                        :key="index"
                      >
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.company_name }}</td>
                            <td>{{ item.position_name }}</td>
                            <td>{{ item.created_at }}</td>
                            <td>{{ item.deleted_at }}</td>
                            <td>{{ item.updated_at }}</td> 
                          <td>{{ item.employee_name }}</td>
                          <td>
                                    <v-btn icon>

                                        <v-icon  
                                              class="ma-2" 
                                              color="primary lighten-2"
                                              @click="edit(item. company_code, item.position_name , item.position_code)"
                                              >mdi-book-edit
                                        </v-icon>

                                    </v-btn>

                                  <v-btn icon>
                                          <v-icon
                                          class="ma-2"   
                                          color="red lighten-2"
                                            @click="Delete(item.company_code,item.position_code)"
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
				            positions:[],
				            position_sel:[],
				            company_code: null,
				            position_code:null, 
				            position_name_input:null,
				            action:'ADD', 
				            company_code_orig: null, 
				            IsCancelShow:false, 
				        } 
				}, 
				created(){
				        axios.get('api/position').then(res=>{
         
				              this.companies= res.data.Company
				              this.positions=res.data.Positions
				        })
				},

         computed:{

      
        filterpos(){
               if(this.company_code != null){
                  return this.positions.filter(rec=>
                        {
                      return rec.company_code ==this.company_code
                    })
              }else
               { 
                 return this.positions
                 }
             
            }, 

      }, 
			  methods:{
			      save(){
					        axios.post('api/position' , 
					        {action: this.action ,
					         company_code:  this.company_code , 
					          position_name: this.position_name_input  ,
					           company_code_orig:this.company_code_orig , 
					           position_code: this.position_code
					            }).then(res=> {
					                    
					                  if(res.data=='blank'){
					                      alert('Company and position Name are required ')
					                  }else if(res.data == 'exist'){
					                      alert('position already existed')
					                  }else{
                              // alert('refresh')
					                      this.positions=res.data.Positions
					                  }
                      })
                             
                } 
                , 
			
			      edit(com_code , dep_name , dep_code){
						        this.action='UPDATE'
						        this.IsCancelShow=true
						        this.company_code=com_code
						        this.position_name_input=dep_name
						        this.company_code_orig=com_code
						        this.position_code=dep_code
			
			      },
			      
			
			      Cancel(){
			          this.company_code=null
			          this.position_name_input =''
			          this.IsCancelShow=false
			          this.action='ADD'
               
			      }, 
      
      
    
			       Delete(companyCode, poscode){
                    if(confirm('Are you sure you want to delete? ')){
                              this.action="DELETE"
                              axios.post('api/position' ,
                                        {action: this.action, 
                                        company_code:companyCode, 
                                        position_code : poscode
                            }).then(res=>{
                                  this.positions=res.data.position
                                  })
                    
                }  
			            
			
			  		}

  				}, 
  }
</script>


