<template>
   <v-app>
      <div>

       <login-app v-if="isLogin==0"></login-app>

       <div v-else>
       <drawer-app  ></drawer-app>
         
         <v-main>
            <div>
            <router-view></router-view>
            </div>
         </v-main> 
         </div>
      </div>
   </v-app>
</template>

<script>
import DrawerApp from "../components/NavbarComponents";
import LoginApp from "../components/Login2";

    export default {
       components: {DrawerApp , LoginApp },
       data(){
          return{
             isLogin:null, 

          }
       } , 



       created(){
             this.isLogin=this.$store.state.isLogin

       }

    }
</script>