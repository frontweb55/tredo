<template>
    <div class="container">
        <table class="table  table-responsive">
            <thead class="thead-dark">
            <tr>
                <th></th>
                <th v-for="department in departments">
                    {{department.name}}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(emplo) in employees">
                <td>{{emplo.name}}</td>
                <th v-for="department in departments" class="text-center" :class="emplo.selectDepartments.includes(department.id) ? 'table-success' : ''" >
                    <span v-if="emplo.selectDepartments.includes(department.id)">+</span>
                </th>
            </tr>
            </tbody>
        </table>
    </div>

</template>
<script>


    export default {
        data() {
            return {
                departments: {},
                employee:{},
            }
        },
        methods: {

            getDepartments(){
                axios.get('department')
                    .then(response => {
                        if (response.data.data){
                            this.departments = response.data.data;
                        }
                    })
                    .catch(error => {
                        console.log(error.response);
                    });
            },
            getEmployees(){
                axios.get('employee')
                    .then(response => {
                        if (response.data.data){
                            this.employees = response.data.data;
                        }
                        console.log(this.employees);
                    })
                    .catch(error => {
                        console.log(error.response);
                    });
            },
        },
        mounted () {
            this.getEmployees();
            this.getDepartments();
        },

    }
</script>

<style scoped>

</style>
