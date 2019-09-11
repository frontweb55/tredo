import VueRouter from 'vue-router'
// Pages
import IndexComponent from './components/IndexComponent'
import DepartmentComponent from './components/DepartmentComponent'
import EmployeeComponent from './components/EmployeeComponent'

// Routes
const routes = [

    {
        path: '/',
        name: 'index',
        component: IndexComponent,
    },
    {
        path: '/department',
        name: 'department',
        component: DepartmentComponent,
    },
    {
        path: '/employee',
        name: 'employee',
        component: EmployeeComponent,
    }
];

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})
export default router
