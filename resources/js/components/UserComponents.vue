<template>
<v-card>
  <v-row  class="pa-2" >
 <v-col >
              <v-text-field  
                      dense  type="text" 
                      placeholder="Enter email" 
                      v-model="email" 
                      clearable
            >  
                </v-text-field>
</v-col>

<v-col>
             <v-text-field  
              dense  type="text" 
              placeholder="Enter  your name" 
              v-model="name" 
              clearable
            >  
                </v-text-field>
</v-col>
      


<v-col>
             <v-text-field  
              dense  type="text" 
              placeholder="Enter  your password" 
              v-model="pword" 
              clearable
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
            <th class="text-left">Email </th>  
            <th class="text-left"> Name </th>  

            <th class="text-left">Created Date</th>
            <!-- <th class="text-left">Deleted Date</th> -->
            <th class="text-left">Updated Date</th>
            <!-- <th class="text-left">Updated By</th> -->
              <th class="text-center">Action</th>
          </tr>
      </thead>
      <tbody >
              <tr
                v-for="(item , index)  in users"  
                :key="index"  
          >
                  <td >{{ index + 1 }}</td>
                  <td>{{ item.email }}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.created_at }}</td>
                  <!-- <td>{{ item.deleted_at }}</td> -->
                  <td>{{ item.updated_at }}</td> 
                  <!-- <td>{{ item.employee_name }}</td> -->
                  <td class="text-center">
                            <v-btn
                            class="ma-2"
                            text
                            icon
                            color="red lighten-2"
                            >
                                <v-icon
                                @click="deleteUser(item.email)"
                                >mdi-delete</v-icon>
                          </v-btn>

                          <v-btn
                                  text
                                  icon
                                  color="blue lighten-2"
                                  @click="edit( item.email ,  item.name , item.id)"
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
        name:null, 
        email:null,
        pword:null,
        isSave:null,
        isCancelShow:false,
        action:'ADD' ,
        users: [],
        id:null,
          }
      }, 


      created(){
       axios.get('api/user').then(res=>{
         this.users=res.data
         console.log( this.users)
       })
      },
      

  methods:{
    save(){


    
           axios.post('api/user' , 
           { IsAction:this.action , 
              email:this.email, 
              name:this.name ,
              pword:this.pword, 
              id:this.id
              })
                  .then(res=>{
                    
                    if(res.data == "exist"){
                        alert("User alrady exisiting!!!")
                      }
                      else if(res.data=='blank'){
                        alert("user must not be blank!!!")
                      }
                      else{
                              if(res.data.length >0 ){
                                this.users=res.data
                              } 
                      }
                  })
      },





     edit(email , uname, id){
              this.action='UPDATE'
              this.isCancelShow=true
              this.email=email
              this.name =uname
              this.pword=''
              this.id=id
    } , 



    cancel(){
            this.isCancelShow=false
            this.action="ADD"
            this,this.email=''
            this.name=''
            this.pword=''
    }, 



    deleteUser(email){
      if(confirm('Are you sure to delete  ? ' )){

         axios.post('api/user' ,
          {IsAction:'DELETE' , email: email}).then(res=>{
                this.users=res.data
        })
           
      }
    }
  }
}
</script> 
