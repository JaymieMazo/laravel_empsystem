<template>
    <v-card>
        <v-row  clas="px-2" >
            <v-col cols=5   class="mx-10  my-10 py-5"  >
                            <v-row class="HR px-2 py-5 px-5">
                    
                                    <p>HR HIRING DASHBOARD</p>
                                   
                    
                            </v-row>

                 <v-row>
                        <v-col  cols="1" sm="3"  > 
                                        <label class="p1 mx-5">Open Positions</label>
                                        <b><label class="p2  py-3 mx-5"  >48</label></b> 
                         </v-col>
                        <v-col  cols="1" sm="3"> 
                                        <label class="p1 mx-5 ">Newly Hired </label>
                                        <b><label   class="p2  mx-5 py-3"  >15</label></b> 
                        </v-col>
                        <v-col  cols="1"  > 
                                        <label class="p1 mx-5 " >TotalEmployees</label>
                                        <b><label   class="p2  mx-5 py-3"  >25,000</label></b> 
                        </v-col>

                </v-row>
            </v-col>
            <v-col cols=3>
                           <v-card class="my-3">
                                    <v-card-title  >
                                        <v-icon color="pink" x-large >mdi-account</v-icon>
                                        Admin
                                    </v-card-title>

                            </v-card>

                             <v-card class="my-3">
                                <v-card-title  >
                                    <v-icon   color="blue" x-large>mdi-account-outline</v-icon>
                              Employees
                                <v-spacer></v-spacer>
                                <span style="font-size:20px; font-color:blue;" >{{this.count["Employee"]}}</span>
                                </v-card-title>
                           
                         
                            </v-card>

                             <v-card >  
                                    <v-card-title  >
                                        <v-icon   color="green" x-large>mdi-account-lock</v-icon>
                                        Users
                                         <v-spacer></v-spacer>
                                        <span style="font-size:20px; font-color:blue;" 
                                        >{{this.count["User"]}}</span>
                               
                                        </v-card-title>
                                

                            </v-card>                    
            </v-col>

             <v-col cols=3>
                         <v-card class="my-3">
                                <v-card-title  >
                                    <v-icon   color="black" x-large>mdi-domain</v-icon>  
                                    Company
                                     <v-spacer></v-spacer>
                                        <span style="font-size:20px; font-color:blue;" 
                                        >{{this.count["Company"]}}</span>
                                </v-card-title>
                
                            </v-card>


                             <v-card>
                                    <v-card-title  >
                                        <v-icon   color="teal" x-large>mdi-account-group</v-icon>
                                        Department
                                         <v-spacer></v-spacer>
                                        <span style="font-size:20px; font-color:blue;" 
                                        >{{this.count["Department"]}}</span>
                                    </v-card-title>
                              
                            </v-card>


                             <v-card class="my-3">
                                    <v-card-title  >
                                        <v-icon   color="orange" x-large>mdi-chart-pie</v-icon>
                                        Sections
                                         <v-spacer></v-spacer>
                                        <span style="font-size:20px; font-color:blue;" 
                                        >{{this.count["Section"]}}</span>
                                    </v-card-title>
                                    
                            </v-card>
                            
            </v-col>
            
            
        </v-row>

<v-divider></v-divider>

           <v-card-text>
                      <highcharts  id="container" :options="chartOptions"></highcharts>
           </v-card-text>

        </v-card>

</template>

<script>
export default {
   
   data(){
        return{
              img:require('../../images/acc1.png'),
              count:[],
              count2:null,
              monthly_data:[],
              jan:2,
              
              chartOptions:{

                   chart: {
                    type: 'column',
                    width:970,
                    },
                title: {
                    text: 'Monthly Resignation Rate as of 2020'
                        },
               
                accessibility: {
                        announceNewData: {
                        enabled: true
                                    }
                        },
                xAxis: {
                    type: 'category',
                },
                yAxis: {
                            title: {
                                text: 'No. of employees Resigned'
                            }, 
                    },

                legend: {
                    enabled: false
                },
                
    plotOptions: {
                series: {
                    borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y:.1f}'
                            }
                }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:}</b> of total<br/>'
    },


    series: [
                {
            name: "Month",
            colorByPoint: true,
            data: [
                    ]
                }]
        
              },
    }
    },




    created(){
        axios.get('api/home' ).then(res=>{
        this.count=res.data
      
        })
    }
    , 

 mounted: function () {
    setTimeout(function(){ 
        this.message = 'Data Fetched';

          axios.get('api/home' ).then(res=>{
         this.monthly_data=res.data.Months
            console.log( res.data.Months)
        this.chartOptions.series[0].data =  this.monthly_data;
         })
    }.bind(this), 100);
  },



    computed:{
        count1(){
                 axios.get('api/home' ).then(res=>{
                        return res.data.Allemp + 2
        })
        }, 

        count3(){
             axios.get('api/home' ).then(res=>{
                    this.monthly_data=res.data.Months
                    console.log(this.monthly_data[0])
                    return   this.monthly_data[0];
                 })
        }
    }
}
</script>


<style scoped>
.HR{
    background-color: burlywood;
    width:100%;
    height:80px;
    text-align: center;
    font-family: arial;
    color:darkmagenta;
    font-size:25px;

}



.p1{
background-color: lightpink;
width:100px;
text-align: center;
}


.p2{
height:50px;
width:100px;
text-align: center;
border: 1px solid grey;
font-size: 20px;
}

.cl{
    background-color: yellow;
    height: 10px;
}

.count{
    text-align:center;
}


</style>