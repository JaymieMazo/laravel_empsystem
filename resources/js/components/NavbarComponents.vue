<template>
  <div>


    <v-app-bar color="teal" dense app dark clipped-left >
                <v-app-bar-nav-icon @click.stop="drawer = !drawer">
                </v-app-bar-nav-icon>
                <v-toolbar-title align="center" class="ml-5"
                style=" font-family:  Console Courier New monospace ; font-size:35px">
                  Employee Management System
                </v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn icon>
              <v-icon>mdi-bell-ring</v-icon>
          </v-btn>


              <v-menu transition="scroll-y-transition">

                <template v-slot:activator="{on, attrs}">
                  
                    <v-btn icon v-on="on" v-bind="attrs">
                      <v-icon >mdi-account-circle</v-icon>
                    
                    </v-btn>
                    
                </template>




                
                    <v-list width="160px"  style="background-color:transparent">

                          <v-list-item >
                            <v-btn > 
                            <v-icon>mdi-cog</v-icon>
                            Settings
                            </v-btn>
                          </v-list-item>
                          <v-list-item>
                          <v-btn>
                          <v-icon>mdi-logout</v-icon>
                          Sign-out
                          </v-btn>
                          </v-list-item>
                    </v-list>
            </v-menu>
                  
  
    </v-app-bar>




    <v-navigation-drawer 
    v-model="drawer" 
    clipped 
    app 
    width="277px"
    color="teal lighten-4">

 <v-list>
      <v-list-item-group  >
              <template v-for='(NavItem,key) in NavItems'>
                    <template v-if="NavItem.subLinks == null">
                        <v-list-item  :to="NavItem.router" :key="key">
                            
                              <v-list-item-icon>
                                  <v-icon>{{ NavItem.icon }}</v-icon>
                              </v-list-item-icon>

                              <v-list-item-title>{{ NavItem.title }}</v-list-item-title>
                        </v-list-item>
                    </template>

                    <template v-else>
                                <v-list-group :key="key"  :valu="false" no-action  :prepend-icon="NavItem.icon">
                                        
                                        <template v-slot:activator>
                                              <v-list-item-content>
                                                    <v-list-item-title>{{ NavItem.title }}</v-list-item-title>
                                              </v-list-item-content>
                                        </template>

                                        <v-list-item  
                                              v-for="(subItem , key) in NavItem.subLinks" 
                                              :key="key" 
                                                :to="subItem.router">
                                              <v-list-item-icon>
                                                      <v-icon>{{ subItem.icon }}</v-icon>
                                                </v-list-item-icon>

                                              <v-list-item-title  v-text="subItem.text" >  
                                              XAS</v-list-item-title>
                                        </v-list-item>
                                  </v-list-group>
                      </template>    
               </template>
       </v-list-item-group>
 </v-list>

    <template v-slot:append>
        <div class="pa-2" @click="logout()"><v-btn dark block>
        Logout</v-btn></div>
      </template>
    </v-navigation-drawer>
  </div>

</template>


<script>
export default {
  components: {},
  data() {
    return {
      drawer: true,
      NavItems: [
        { title: "Dashboard", 
          icon: "mdi-view-dashboard",
          router: "/" 
          },
          { 
            title: "Master maintenance", 
            icon: "mdi-cog",
            subLinks:[
                      {text:"Employees", router:  "/Employee" , icon: "mdi-human-male-female"},
                      {text:"Company", router:  "/Company" , icon: "mdi-domain"},
                      {text:"Department", router: "/Department",  icon: "mdi-account-group"},
                      {text:"Section", router:  "/Section",  icon: "mdi-bank" },
                      {text:"Users", router:  "/User" ,  icon: "mdi-account-lock"}, 
                      {text:"Job Position", router:  "/position" ,  icon: "mdi-seat-outline"}
                    ]
          }, 
            { 
              title: "junks", 
              icon: "mdi-trash-can",
              router: "/junks" 
            },
      ],
    
    };
  },

  created() {},
  updated() {},
  watch: {},
  computed: {},
  methods: {
    mChangeRouter(data) {
        if (this.$router.app._route.path != data) {
            this.$router.push(data);
        }
    },
    logout(){
          this.$store.commit('LoggedIn' , { IsLogin:0 })
          location.href="/login"
    }
  },
};
</script>
