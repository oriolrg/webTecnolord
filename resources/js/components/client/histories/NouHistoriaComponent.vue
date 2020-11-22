<template>
    <div>
        <table class="table no-wrap user-table mb-0">
            <td>
                <div class="form-group">
                    <label for="name">Titol Historia:</label>
                    <textarea type="text" class="form-control" name="name" id="name" v-model="fields.name" />
                    <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label for="name">Com a:</label>
                    <textarea type="text" class="form-control" name="como" id="como" v-model="fields.como" />
                    <div v-if="errors && errors.como" class="text-danger">{{ errors.como[0] }}</div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label for="name">Que vull que faci:</label>
                    <textarea type="text" class="form-control" name="quiero" id="quiero" v-model="fields.quiero" />
                    <div v-if="errors && errors.quiero" class="text-danger">{{ errors.quiero[0] }}</div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label for="name">Perque vull que ho faci:</label>
                    <textarea type="text" class="form-control" name="para" id="para" v-model="fields.para" />
                    <div v-if="errors && errors.para" class="text-danger">{{ errors.para[0] }}</div>
                </div>
            </td>
            <td><br>
                <button  v-if="fields.id" v-on:click="actualitza" class="btn btn-primary">Actualitza</button>
                <button  v-if="fields.id" v-on:click="Cancela" class="btn btn-danger">Cancela</button>
                <button  v-else v-on:click="nou" class="btn btn-primary">Crear Historia</button>
            </td>
        </table>
    </div>
</template>

<script>
    import { clientsHistoriasUrl } from '../../../config.js';
    export default {
        //declaro la propietat que rebo del component pare projecte_id
        props: {
            projecte_id:Number,
            data_historia:Object,
        },
        watch: {
            'data_historia': function(arMsg) {
                //obting id user a editar
                this.fields = arMsg;
            }
        },
        data () {
            return {
                data_results: [],
                fields: {},
                errors: {},
                url: clientsHistoriasUrl,
            }
        },
        methods: {
            nou: function (event) {
                this.fields.id = this.projecte_id;
                this.data_results = [];
                axios.post(this.url + '/nou', this.fields).then(response => {
                    alert('Historia Creada!');
                    this.data_results = response.data;
                    this.$emit('noves_histories', this.data_results);
                    this.fields = {};
                }).catch(error => {
                    if (error.response.status === 422) {
                        alert(422);
                    this.errors = error.response.data.errors || {};
                    }
                    if (error.response.status === 500) {
                        alert(500);
                    this.errors = error.response.data.errors || {};
                    }
                });
            },
            actualitza: function (event) {
                axios.post(this.url + '/actualitza', this.fields).then(response => {
                    alert('Historia Actualitzada!');
                    this.data_results = response.data;
                    this.fields = {};
                    this.$emit('nous_usuaris', this.data_results);
                }).catch(error => {
                    if (error.response.status === 301) {
                    alert("Error del servidor");
                    this.errors = error.response.data.errors || {};
                    }
                    if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                    }
                    if (error.response.status === 500) {
                    alert("Error del servidor");
                    this.errors = error.response.data.errors || {};
                    }
                });
            },
            Cancela: function (event) {
                this.fields = {};
            },
        },
        mounted() {
            console.log('Component Formulari Histories Muntat.')
        },
    }
</script>