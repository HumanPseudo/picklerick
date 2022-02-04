<script>
    export default {
        data(){
            return{
                id:"", 
                name:"", 
                gender:"", 
                update:0, 
                arrayTasks:[], 
            }
        },
        methods:{
            getTasks(){
                let me =this;
                let url = '/tareas' 
                axios.get(url).then(function (response) {
                    
                    me.arrayTasks = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            getMortys(paramId){
                let me =this;
                let rest=[];
                let id=paramId;
                let name='';
                let gender='';
                let pre='https://rickandmortyapi.com/api/character/'

                let url = pre + id.toString() 
                axios.get(url).then(function (response) {                    
                    console.log('here');
                    me.rest = response.data;
                    console.log(me.rest);
                    me.id = me.rest.id;
                    me.name = me.rest.name;
                    me.gender = me.rest.gender;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            saveTasks(){
                let me =this;
                let url = '/tareas/guardar' 
                axios.post(url,{ 
                    'id':this.id,
                    'name':this.name,
                    'gender':this.gender,
                }).then(function (response) {
                    me.getTasks();
                    me.clearFields();
                })
                .catch(function (error) {
                    console.log(error);
                });   

            },
            updateTasks(){
                let me = this;
                axios.put('/tareas/actualizar',{
                    'id':this.id,
                    'name':this.name,
                    'gender':this.gender,
                }).then(function (response) {
                   me.getTasks();
                   me.clearFields();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(data){ 
                this.update = data.id
                let me =this;
                let url = '/tareas/buscar?id='+this.update;
                axios.get(url).then(function (response) {
                    me.id= response.data.id;
                    me.name= response.data.name;
                    me.gender= response.data.gender;

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                }); 
            },
            deleteTask(data){
                let me =this;
                let task_id = data.id
                if (confirm('¿Seguro que deseas borrar esta tarea?')) {
                    axios.delete('/tareas/borrar/'+task_id
                    ).then(function (response) {
                        me.getTasks();
                    })
                    .catch(function (error) {
                        console.log(error);
                    }); 
                }
            },
            clearFields(){/*Limpia los campos e inicializa la variable update a 0*/
                this.id = "";
                this.name = "";
                this.gender = "";
                this.update = 0;
            }
        },
        mounted() {
           this.getTasks();
        }
    }
</script>
<template>
    <div class="container container-task">
        <div class="row">
            <div class="col-md-6">
                <h2>Lista</h2>
                <table class="table text-center"><!--Creamos una tabla que mostrará todas las tareas-->
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="task in arrayTasks" :key="task.id"> <!--Recorremos el array y cargamos nuestra tabla-->
                                <td v-text="task.id"></td>
                                <td v-text="task.name"></td>
                                <td v-text="task.gender"></td>
                                <td>
                                    <!--Botón modificar, que carga los datos del formulario con la tarea seleccionada-->
                                    <button class="btn" @click="loadFieldsUpdate(task)">Modificar</button>
                                    <!--Botón que borra la tarea que seleccionemos-->
                                    <button class="btn" @click="deleteTask(task)">Borrar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <div class="col-md-6">
                <div class="form-group"><!-- Formulario para la creación o modificación de nuestras tareas-->
                    <label>ID</label>
                    <input v-model="id" type="text" class="form-control">

                    <label>Name</label>
                    <input v-model="name" type="text" class="form-control">

                    <label>Gender</label>
                    <input v-model="gender" type="text" class="form-control">
                </div>
                <div class="container-buttons">
                    <!-- Botón que añade los datos del formulario, solo se muestra si la variable update es igual a 0-->
                    <button v-if="update == 0" @click="saveTasks()" class="btn btn-success">Añadir</button>
                    <!-- Botón que modifica la tarea que anteriormente hemos seleccionado, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="updateTasks()" class="btn btn-warning">Actualizar</button>
                    <!-- Botón que limpia el formulario y inicializa la variable a 0, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="clearFields()" class="btn">Atrás</button>

                    <button @click="getMortys(id)" class="btn btn-success">Buscar</button>

                </div>
            </div>
        </div>
    </div>
</template>