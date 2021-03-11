<template>
<!-- <v-container fluid fill-height class="ma-0 pa-0"> -->
    <v-row no gutters justify="center" align="center">
        <v-card width="900" style="margin:300px 0px ; border:2pt solid grey" elevation="2pt">
            <v-card-text>
                
                <v-row align="center" justify="space-around">
                   
                    <v-col cols=6 style="border-right:1px solid black">
                        <v-img margin-top="20px" height="200" width="400"  :src=ImgUrl />
                    </v-col>

                    <v-col cols=4>
                        <v-card-title style="color:tomato; font-size:35px ; font-family:cambria">Login</v-card-title>
                        <v-spacer></v-spacer>
                        <v-text-field text v-model="email" label="Username" outlined dense 
                        prepend-inner-icon="mdi-account" clearable required :counter="10" >
                        </v-text-field>

                        <v-text-field    :type="show1 ? 'text' : 'password'" 
                        :append-icon="show1 ? 'mdi-eye':'mdi-eye-off'"  
                        @click:append="show1=!show1"
                         text v-model="pword"
                         label="Password" outlined dense 
                         prepend-inner-icon="mdi-lock" 
                         :counter="10"  
                         ></v-text-field>
                      
                        <div align="right">
                        <v-btn 
                        color="primary"
                         width="270"
                          @click="mLogin()">Login</v-btn>
                        </div>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-row>
<!-- </v-container> -->
</template>

<script>


export default {
    data() {
        return {
            show1:false,
            email: null,
            pword: null,
            User: {
            },
            isUserExists:null,
            ImgUrl: require('../../images/Logo.jpg'),
  
        }
    }, 

    methods:{
        mLogin(){
                axios.post('api/login',{email: this.email,  pword: this.pword}).then(res => {
                this.isUserExists=res.data
 
                this.$store.commit("LoggedIn" , {IsLogin:  this.isUserExists })
                  location.href="/"

                });
 
        } , 
    },
}
</script>
