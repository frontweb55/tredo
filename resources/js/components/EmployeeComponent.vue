<template>
    <div class="container">
        <a class="btn btn-lg btn-primary mb-3" href="" role="button" @click.prevent="show()">Добавить сотрудника</a>
        <table class="table table-responsive">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Имя</th>
                <th scope="col">Фамилия</th>
                <th scope="col">Отчество</th>
                <th scope="col">Пол</th>
                <th scope="col">Заработная плата</th>
                <th scope="col">Отделы</th>
                <th scope="col">Редактировать</th>
                <th scope="col">Удалить</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(emplo, key) in employees">
                <td>{{emplo.name}}</td>
                <td>{{emplo.surname}}</td>
                <td>{{emplo.patronymic}}</td>
                <td>{{emplo.gender_text}}</td>
                <td>{{emplo.wage}}</td>
                <td>{{emplo.departments}}</td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm" @click.prevent="show(key, emplo.id)">Редактировать</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" @click.prevent="deleteEmployee(emplo.id)">Удалить</button>
                </td>
            </tr>
            </tbody>
        </table>

        <modal name="form"
               height="auto"
               :scrollable="true"
               width="50%">
            <div class="container">
                <form>
                    <h2 v-if="editEmployee"> Редактировать данные сотрудника</h2>
                    <h2 v-else>Добавить сотрудника</h2>
                    <hr>
                    <div class="alert alert-danger" role="alert" v-if="errorText">
                        Произошла ошибка попробуйте позже
                    </div>
                    <div class="alert alert-success" role="alert" v-if="success">
                        <p v-if="editId">
                            Информация успешно обновлена
                        </p>
                        <p v-else>
                            Сотрудник успешно добавлен
                        </p>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Имя</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" :class="validationErrors.name ? 'is-invalid' : ''" id="name" placeholder="Имя" v-model="employee.name">
                        </div>
                        <div class="offset-sm-2 col-sm-10" v-if="validationErrors.name">
                            <p v-for="(value) in validationErrors.name" class="error_label">{{ value }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="surname" class="col-sm-2 col-form-label">Фамилия</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" :class="validationErrors.surname ? 'is-invalid' : ''" id="surname" placeholder="Фамилия" v-model="employee.surname">
                        </div>
                        <div class="offset-sm-2 col-sm-10" v-if="validationErrors.surname">
                                <p v-for="(value) in validationErrors.surname" class="error_label">{{ value }}</p>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="patronymic" class="col-sm-2 col-form-label">Отчество</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" :class="validationErrors.patronymic ? 'is-invalid' : ''" id="patronymic" placeholder="Отчество" v-model="employee.patronymic">
                        </div>
                        <div class="offset-sm-2 col-sm-10" v-if="validationErrors.patronymic">
                            <p v-for="(value) in validationErrors.patronymic" class="error_label">{{ value }}</p>
                        </div>
                    </div>
                    <fieldset class="form-group">
                        <div class="row">
                            <label class="col-form-label col-sm-2 pt-0">Пол</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input"  type="radio" name="gender" value="male" id="male_radio" checked v-model="employee.gender">
                                    <label class="form-check-label" for="male_radio">
                                        Мужской
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female_radio" value="female" v-model="employee.gender">
                                    <label class="form-check-label" for="female_radio">
                                        Женский
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="offset-sm-2 col-sm-10" v-if="validationErrors.gender">
                            <p v-for="(value) in validationErrors.gender" class="error_label">{{ value }}</p>
                        </div>
                    </fieldset>

                     <div class="form-group row">
                        <label for="wage" class="col-sm-2 col-form-label">Заработная плата</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control"  :class="validationErrors.wage ? 'is-invalid' : ''" id="wage" placeholder="Заработная плата" v-model="employee.wage">
                        </div>
                         <div class="offset-sm-2 col-sm-10" v-if="validationErrors.wage">
                             <p v-for="(value) in validationErrors.wage" class="error_label">{{ value }}</p>
                         </div>
                    </div>
                    <div class="form-group row">
                        <label for="departments" class="col-sm-2 col-form-label">Отделы</label>
                        <select class="custom-select col-sm-10" :class="validationErrors.departments ? 'is-invalid' : ''" id="departments" multiple v-model="selected">
                            <option v-for="department in departments" :value="department.id" >{{department.name}}</option>
                        </select>
                        <div class="offset-sm-2 col-sm-10" v-if="validationErrors.departments">
                            <p v-for="(value) in validationErrors.departments" class="error_label">{{ value }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" @click.prevent="saveEmployee()">Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>

        </modal>
        <modal name="errorModal"
                height="auto">
            <div class="container">
                <div class="alert alert-danger m-2" role="alert">
                    Произошла ошибка попробуйте позже
                </div>
            </div>
        </modal>
    </div>

</template>

<script>


    export default {
        data() {
            return {
                departments: {},
                employee:{
                    name:undefined,
                    surname:undefined,
                    patronymic:undefined,
                    gender:undefined,
                    wage:undefined,
                },
                selected:[],
                validationErrors:{},
                errors:undefined,
                errorText:undefined,
                success:undefined,
                employees:undefined,
                editEmployee:false,
                selectDepartments: [],
                editId:undefined,
            }
        },
        methods: {
            show(key = undefined, id = undefined) {
                if  ((id !== undefined) && (key !== undefined)){
                    this.employee = this.employees[key];
                    this.selected = this.employees[key].selectDepartments;
                    this.editId = id;
                    console.log(this.selectDepartments);
                }else{
                    this.selected = [];
                    this.success = undefined;
                    this.editId = undefined;
                    this.resetInputs();
                }
                this.success = false;
                this.$modal.show('form');
            },
            hide() {
                this.$modal.hide('hello');
            },
            saveEmployee() {
                this.errorText = undefined;
                let params = this.employee,
                    url = 'employee',
                    method = 'post';
                    params.departments = this.selected;
                if(this.editId !== undefined){
                    url += '/' + this.editId;
                    method = 'put';
                }
                axios({
                    method: method,
                    url: url,
                    data: params
                }).then(response => {
                    if (this.editId === undefined){
                        this.resetInputs();
                        this.selected = [];
                    }
                    this.success = true;
                    if (response.data.data){
                        this.employees = response.data.data;
                    }
                })
                .catch(error => {
                    if (error.response.status == 422){
                        this.validationErrors = error.response.data.errors;
                    }else{
                        this.errorText = true;
                        this.success = false;
                    }
                });
            },
            resetInputs() {
                this.employee = {
                    name:undefined,
                    surname:undefined,
                    patronymic:undefined,
                    gender:undefined,
                    wage:undefined,
                };
            },
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
            deleteEmployee(id){
                axios.delete('employee/' + id)
                    .then(response => {
                        if (response.data.data){
                            this.employees = response.data.data;
                        }
                    })
                    .catch(error => {
                        this.$modal.show('errorModal');
                    });
            }

        },
        mounted () {
            this.resetInputs();
            this.getEmployees();
            this.getDepartments();
        },
        watch: {
            selected: function () {
                this.validationErrors.departments = undefined;
            },

            'employee.name': function () {
                this.validationErrors.name = undefined;
            },
            'employee.surname': function () {
                this.validationErrors.surname = undefined;
            },
            'employee.patronymic': function () {
                this.validationErrors.patronymic = undefined;
            },
            'employee.gender': function () {
                this.validationErrors.gender = undefined;
            },
            'employee.wage': function () {
                this.validationErrors.wage = undefined;
            },
        }
    }
</script>

<style scoped>
    label{
        font-size: 14px;
    }
   form{
       padding: 20px;
   }
    .error_label{
        font-size: 13px;
        color: red;
    }
</style>
