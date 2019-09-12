<template>
    <div class="container">
        <a class="btn btn-lg btn-primary mb-3" href="" role="button" @click.prevent="show()">Добавить отдел</a>
        <table class="table table-responsive">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Название отдела</th>
                <th scope="col">Количество сотрудников отдела</th>
                <th scope="col">Максимальная ЗП</th>
                <th scope="col">Редактировать</th>
                <th scope="col">Удалить</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(dep, key) in departments">
                <td>{{dep.name}}</td>
                <td>{{dep.employees_count}}</td>
                <td>{{dep.max_wage}}</td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm" @click.prevent="show(key, dep.id)">Редактировать</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" @click.prevent="deleteDepartment(dep.id)">Удалить</button>
                </td>
            </tr>
            </tbody>
        </table>

        <modal name="form"
               height="auto"
               :scrollable="true"
               :adaptive="true">
            <div class="container">
                <form>
                    <h2 v-if="editId"> Редактировать отдел</h2>
                    <h2 v-else>Добавить отдел</h2>
                    <hr>
                    <div class="alert alert-danger" role="alert" v-if="errorText">
                        Произошла ошибка попробуйте позже
                    </div>
                    <div class="alert alert-success" role="alert" v-if="success">
                        <p v-if="editId">
                            Информация успешно обновлена
                        </p>
                        <p v-else>
                            Отдел успешно добавлен
                        </p>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Название отдела</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" :class="validationErrors.name ? 'is-invalid' : ''" id="name" placeholder="Имя" v-model="department.name">
                        </div>
                        <div class="offset-sm-2 col-sm-10" v-if="validationErrors.name">
                            <p v-for="(value) in validationErrors.name" class="error_label">{{ value }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" @click.prevent="saveDepartment()">Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>

        </modal>
        <modal name="errorModal" height="auto">
            <div class="container">
                <div class="alert alert-danger m-2" role="alert">
                    Произошла ошибка попробуйте позже
                </div>
            </div>
        </modal>
        <modal name="errorModalDepartment" height="auto">
            <div class="container">
                <div class="alert alert-danger m-2" role="alert">
                    Нельзя удалить отдел в котором есть сотрудники
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
                department:{
                    name:undefined,
                },
                selected:[],
                validationErrors:{},
                errors:undefined,
                errorText:undefined,
                success:undefined,
                editId:undefined,
            }
        },
        methods: {
            show(key = undefined, id = undefined) {
                if  ((id !== undefined) && (key !== undefined)){
                    this.department = this.departments[key];
                    this.editId = id;
                }else{
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
            saveDepartment() {
                this.errorText = undefined;
                let params = {name: this.department.name},
                    url = '/department',
                    method = 'post';
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
                    }
                    this.success = true;
                    if (response.data.data){
                        this.departments = response.data.data;
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
                this.department = {
                    name:undefined,
                };
            },
            getDepartments(){
                axios.get('/department')
                    .then(response => {
                        if (response.data.data){
                            this.departments = response.data.data;
                        }
                    })
                    .catch(error => {
                        console.log(error.response);
                    });
            },
            deleteDepartment(id){
                axios.delete('/department/' + id)
                    .then(response => {
                        if (response.data.data){
                            this.departments = response.data.data;
                        }
                    })
                    .catch(error => {
                        if (error.response.status == 403){
                            this.$modal.show('errorModalDepartment');
                        }else{
                            this.$modal.show('errorModal');
                        }
                    });
            }

        },
        mounted () {
            this.getDepartments();
        },
        watch: {
            selected: function () {
                this.validationErrors.departments = undefined;
            },

            'department.name': function () {
                this.validationErrors.name = undefined;
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
