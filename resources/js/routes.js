import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import Home from './components/home'
import Company from './components/CompanyComponents'
import Department from './components/DepartmentComponents'
import Section from './components/SectionComponents'
import User from './components/UserComponents'
import junks from './components/JunksComponents'
import test from './components/testComponents'
import employee from './components/EmployeeComponents'
import position from './components/PositionComponents.vue'
export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/Company',
            name: 'company',
            component: Company
        },

        {
            path: '/Department',
            name: 'Department',
            component: Department
        },
        
        {
            path: '/Section',
            name: 'Section',
            component: Section
        },
        
        {
            path: '/User',
            name: 'User',
            component: User
        },
     
        {
            path: '/junks',
            name: 'junks',
            component: junks
        },

        {
            path:'/test',
            name:'test',
            component:test
        }, 

        {
            path:'/employee',
            name:'employee',
            component:employee
        }, 

        {
            path:'/position',
            name:'position',
            component:position
        },


       
       
    ],
});