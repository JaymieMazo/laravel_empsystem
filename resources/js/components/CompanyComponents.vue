<template>
<v-card >
  <v-row  class="pa-2" >
        <v-col cols="5" >
              <v-text-field  
              dense  type="text" 
              placeholder="Enter company Name" 
              v-model="company_name_input" 
              clearable
              @click:clear="clearCompanyInput()"
              @input="handelinput()"
            >  
                </v-text-field>
        </v-col>
  
        <v-col >
                <v-btn     
                      style="width:100px;"  
                      type="submit" 
                      color="primary"
                      @click="save()"
                      dense
                 > {{this.action}} </v-btn>

              <v-btn dense 
                    style="width:100px;"  
                      color="primary" 
                      v-show="this.isCancelShow"
                      @click="cancel()"
                      >
                      Cancel
                    </v-btn>
        </v-col>


<v-simple-table >
                <template v-slot:default>
                  <thead >
                    <tr >
                            <th class="text-left">No</th>
                            <th class="text-left">Company Name</th>  
                            <th class="text-left">Created Date</th>
                            <th class="text-left">Updated Date</th>
                            <th class="text-left">Updated By</th>
                              <th class="text-center">Action</th>
                    </tr>
                  </thead>


                  <tbody >
                            <tr
                              v-for="(item , index)  in companies"  
                              :key="item.index"  
                            
                            >
                                    <td >{{ index + 1 }}</td>
                                    <td>{{ item.company_name }}</td>
                                    <td>{{ item.created_at }}</td>
                                    <td>{{ item.updated_at }}</td> 
                                    <td>{{ item.employee_name }}</td>
                                    
            
                                    <td class="text-center">
                                          <v-btn
                                          class="ma-2"
                                          text
                                          icon
                                          color="red lighten-2"
                                          >
                                              <v-icon
                                              @click="deleteCompany(item.company_code)"
                                              
                                              >mdi-delete</v-icon>
                                        </v-btn>

                                        <v-btn
                                       
                                        text
                                        icon
                                        color="blue lighten-2"
                                        @click="edit( item.company_code , item.company_name)"
                                        >
                                        <v-icon>mdi-book-edit</v-icon>
                                        </v-btn>
                                  </td>
                            </tr>
                  </tbody>
                </template>
</v-simple-table>  
</v-row>

</v-card>
</template>
<script>


export default {
     data () {
      return {
    // image: { backgroundImage: "url(https://vuejs.org/images/logo.png)" },
      image:"/resources/images/photo.jpeg",
        company_code_update:null, 
        company_name_input:null,
        isSave:null,
        selected:null,
        isCancelShow:false,
        action:'ADD' ,
        companies: [],
        title:['Company Code' , 'Company Name'  ], 
          }
      }, 


      created(){
       axios.get('api/company').then(res=>{
         this.companies=res.data
         console.log( this.companies)
       })
      },
      

   
       

  methods:{

    save(){
           axios.post('api/company' , 
           { IsAction:this.action , 
              company_name:this.company_name_input ,
              company_code:this.company_code_update
              })
                  .then(res=>{
                    console.log(res.data)
                    if(res.data == "exist"){
                        alert("Company alrady exisiting!!!")
                      }
                      else if(res.data=='blank'){
                        alert("Company must not be blank!!!")
                      }
                      else{
                              if(res.data.length >0 ){
                                this.companies=res.data
                              } 
                      }
                  })
        
      },


     edit(company_code , companyname){
              this.action='UPDATE'
              this.isCancelShow=true
              this.company_code_update=company_code
              this.company_name_input =companyname
    } , 


    clearCompanyInput(){
          this.cancel()
    }, 


    cancel(){
            this.isCancelShow=false
            this.action="ADD"
            this.company_name_input=''
            this.company_code_update=''
    }, 

    handelinput(){
      if(this.company_name_input == ''){
        this.isCancelShow=false
        this.action="ADD"
      }
    } , 

    deleteCompany(company_code){
      if(confirm('Are you sure to delete  ? ' )){
         axios.post('api/company' ,
          {IsAction:'DELETED' , company_code: company_code}).then(res3=>{
          this.companies=res3.data
        })
           
      }
    }
  } 
}
</script> 





