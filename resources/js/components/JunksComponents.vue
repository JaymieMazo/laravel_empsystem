<template>
<v-row class="pa-10">
    
<v-col cols=4>
<v-hover v-slot="{ hover }">
              <v-expand-transition>
                      <v-card  height="300px"  v-show="show">
                          <v-card-title  class="cyan lighten-3 ">
                                  <div class="pa-1">
                                      <v-badge
                                            color="pink"
                                            :content="CategoryData['cntCompany']"
                                          >
                                              Company
                                          </v-badge> 
                                  </div>
                          </v-card-title>      

                            <v-expand-transition>
                          <div 
                                  v-if="hover"
                                  class="d-flex 
                                  transition-fast-in-fast-out
                                  grey lighten-1
                                  v-card--reveal 
                                  display-3 
                                  white--text"
                                  style="height:227.5px;  background-color:green"
                                  @click="viewdialog('Company'), dialog=!dialog"
                                >company
                          </div>
                      </v-expand-transition>                  
                    </v-card>
                </v-expand-transition>
 </v-hover>
              <template   v-if="count !=0" >
                       <v-dialog  v-model="dialog" width="50%"  >
                              <v-card >
                                <v-img 
                                height="200px" width="700px"
                                      margin-top="20px"
                                   :src="ImgUrl">
                                  </v-img>
                                   
                                   <v-card-title>
                       

                                   </v-card-title>


                                <v-card-text>
                                      <v-simple-table>
                                          <thead>
                                              <th>No</th>
                                              <th>Company Name</th>
                                              <th> Select</th>
                                            
                                          </thead>
                                          <tbody>
                                          <tr v-for="(item , index) in deletedData" :key="index">
                                          <td>{{index + 1}}</td>
                                          <td>{{item.name}}</td>
                                           <td>
                                            <v-checkbox v-model="item.retrieveFlg">
                                            </v-checkbox>
                                           </td>
                                          </tr>
                                          </tbody>
                                          </v-simple-table>
                                          </v-card-text>
                                       
                                  <v-card-actions>

                                      <div class="ma-auto">
                                          <span class="ret">RETRIEVE</span>
                                           <v-btn icon   v-model="btnRetrieve" @click="mRetrieve()">
                                       
                                              <v-icon large color="primary">mdi-rotate-right</v-icon>
                                           </v-btn>
                                                  
                                                  <div>
                                         
                                             <v-checkbox class="ret"  large color="primary" v-model="btnSelAll"   @click="mSelectAll()  " label="SELECT ALL" >
                                                                </v-checkbox></div>
                                          

                        
                                            </div>
                                          </v-card-actions>
                                     
                                          </v-card>
                                        
                                          </v-dialog>
                                          </template>
  </v-col>

  <!-- department -->
<v-col cols=4>
              <v-hover v-slot="{hover}">
                      <v-expand-transition>
                            <v-card  height="300px"  v-show="show">
                                  <v-card-title  class="cyan lighten-3 ">

                                  <div class="pa-1">
                                      <v-badge
                                            color="pink"
                                            :content="CategoryData['cntDepartment']"
                                          >
                                              Department
                                          </v-badge>
                                  </div>
                                  </v-card-title>

                            <v-expand-transition>
                                      <div
                                        v-if="hover"
                                        class="d-flex 
                                        transition-fast-in-fast-out
                                        grey lighten-1
                                        v-card--reveal 
                                        display-3 
                                        white--text center"
                                        style="height: 227.5px;"
                                        @click="viewdialog('Department'),  dialog=!dialog"
                                  
                                      >
                                        Dept
                                      </div>
                              </v-expand-transition>
                          </v-card>
                          </v-expand-transition>
              </v-hover>
  </v-col>
 <v-col cols=4>
<v-hover v-slot="{ hover }">
<v-expand-transition>
  <v-card height="300px"   v-show="show"  > 
   <v-card-title  class="cyan lighten-3 ">
      <div class="pa-1">
          <v-badge
                color="pink"
                 :content="CategoryData['cntSection']"
              >
                  Sections
              </v-badge>
      </div>
      </v-card-title>

      <v-expand-transition>
          <div
            v-if="hover"
            class="d-flex 
            transition-fast-in-fast-out
             grey lighten-1
             v-card--reveal 
             display-3 
             white--text"
            style="height: 227.5px;"
            @click="viewdialog('Section'),  dialog=!dialog"
          >
          Sections
          </div>
        </v-expand-transition>

  </v-card >
  </v-expand-transition>
</v-hover>
</v-col>


<v-col>
<v-hover v-slot="{ hover }" >
<v-expand-transition>
      <v-card  height="300px"  v-show="show">
      <v-card-title  class="cyan lighten-3 ">

      <div class="pa-1">
          <v-badge
                color="pink"
                 :content="CategoryData['cntEmployee']"
              >
                  Employees
              </v-badge>
      </div>
      </v-card-title>
      <v-expand-transition>
          <div
            v-if="hover"
            class="d-flex 
            transition-fast-in-fast-out
             grey lighten-1
             v-card--reveal 
             display-3 
             white--text"
            style="height: 227.5px;"
               @click="viewdialog('Employee'),  dialog=!dialog"
          >
          Employees
          </div>
        </v-expand-transition>
    </v-card>
    </v-expand-transition>
    </v-hover>

</v-col>


<v-col>
<v-hover v-slot="{ hover }" >
<v-expand-transition>
      <v-card  height="300px"  v-show="show">
      <v-card-title  class="cyan lighten-3 ">

      <div class="pa-1">
          <v-badge
                color="pink"
                 :content="CategoryData['cntEmployee']"
              >
                  Positions
              </v-badge>
      </div>
      </v-card-title>
      <v-expand-transition>
          <div
            v-if="hover"
            class="d-flex 
            transition-fast-in-fast-out
             grey lighten-1
             v-card--reveal 
             display-3 
             white--text"
            style="height: 227.5px;"
               @click="viewdialog('Employee'),  dialog=!dialog"
          >
          Positions
          </div>
        </v-expand-transition>
    </v-card>
    </v-expand-transition>
    </v-hover>

</v-col>

<v-col>
<v-hover v-slot="{ hover }" >
<v-expand-transition>
      <v-card  height="300px"  v-show="show">
      <v-card-title  class="cyan lighten-3 ">

      <div class="pa-1">
          <v-badge
                color="pink"
                 :content="CategoryData['cntEmployee']"
              >
                  Users
              </v-badge>
      </div>
      </v-card-title>
      <v-expand-transition>
          <div
            v-if="hover"
            class="d-flex 
            transition-fast-in-fast-out
             grey lighten-1
             v-card--reveal 
             display-3 
             white--text"
            style="height: 227.5px;"
               @click="viewdialog('Employee'),  dialog=!dialog"
          >
          Users
          </div>
        </v-expand-transition>
    </v-card>
    </v-expand-transition>
    </v-hover>

</v-col>

  </v-row>

  
</template>

<script>
export default {
 
  data () {
          return {
                  show:false,
                  CategoryData:[],
                  dialog:false,
                  ImgUrl: require('../../images/company.jpeg'),
                  CategoryData:[],
                  category:null,
                  btnRetrieve:false, 
                  btnSelAll:false,    
                  retdata:{},
                  deletedData:[],
                  count:0,
          }
  },


created(){
                this.onLoaddialog()
},

computed:{     
          deletedData1(){
                        return this.CategoryData[this.category]
          }, 


          test(){
            return this.deletedData.filter(
              rec=>{
                return this.deletedData.retrieveFlg==false
              }
        )
      }

       
                
              
          
},

          
  methods: {
    onLoaddialog(){
      axios.get('api/junks').then(res=>{
                  this.CategoryData =res.data
                       var i=0
                        for (i = 0; i < this.CategoryData.length; i++) {
                          Vue.set(this.CategoryData[i], 'deleteflg' , false)
                          }
              })
    },

 
        viewdialog(category){
            this.category=category
            if(this.category=="Company" ) {
                  this.count=  this.CategoryData["cntCompany"]
           }else if(this.category=="Department" ){
                this.count=this.CategoryData["cntDepartment"]
           }else if(this.category=="Section" ){
                  this.count=   this.CategoryData["cntSection"]
           }else if (this.category=="Employee") {
                    this.count=this.CategoryData["cntEmployee"] 
            }

            if(this.count == 0){
                 alert('No data to show!!!')
            }
           

                  this.btnSelAll=false
                  var i=0
                  this.deletedData=this.deletedData1
                    for(i = 0 ; i < this.deletedData1.length; i++){
                  this.editData(i , false)
                  }

              

        
        
        },


          editData(i , isSelectAll){

            if(isSelectAll  == false){
                        
               
                    if(this.category=='Company'){
                          Vue.set(this.deletedData[i], 'id' ,this.deletedData[i].company_code)
                        Vue.set(this.deletedData[i], 'name' ,this.deletedData[i].company_name)
                    }
                    
                    else if (this.category=='Department'){
                        Vue.set(this.deletedData[i], 'id' ,this.deletedData[i].department_code)
                        Vue.set(this.deletedData[i], 'name' ,this.deletedData[i].department_name)
                    }
                    
                    else if (this.category=='Section'){
                        Vue.set(this.deletedData[i], 'id' ,this.deletedData[i].section_code)
                        Vue.set(this.deletedData[i], 'name' ,this.deletedData[i].section_name)  
                    }
                    
                    else if (this.category=='Employee'){
                          Vue.set(this.deletedData[i], 'id' ,this.deletedData[i].employee_code)
                        Vue.set(this.deletedData[i], 'name' ,this.deletedData[i].employee_name)  
                    }
                      Vue.set(this.deletedData[i], 'retrieveFlg' ,false)

                    }
              else{
                          this.deletedData[i].retrieveFlg =this.btnSelAll 
                     }
                          
       },



        mRetrieve(){
                      this.retdata=[]
                      var i=0 
                      for(i=0;i<this.deletedData.length; i++){
                            if(this.deletedData[i].retrieveFlg == true){
                                  this.retdata.push( this.deletedData[i].id
                                  )
                            }
                      }

                      axios.post('api/junks' ,{category:this.category, id: this.retdata} ).then(res=>{
                              this.deletedData=[]
                              this.deletedData=res.data[this.category]
                              var i=0;
                              
                              for(i=0; i  < res.data[this.category].length ;i++){
                                  this.editData(i , false)   
                              }
                            })

      }, 

      mSelectAll(){   
          var i=0
          for(i=0; i < this.deletedData.length; i++){
                  this.editData(i , true )
          }
      }
  }, 



  mounted(){
    this.show=true
  }, 


  
}
</script>
<style scoped>
  .img{
  object-fit: cover;
  }

  .ret{
    font-size:15px;
    font-family:Verdana, Geneva, Tahoma, sans-serif;
    color:grey
  }
</style>

﻿


