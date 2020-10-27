<template>
    <div>
        <table class="table no-wrap user-table mb-0">
            <td>
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" class="form-control" name="name" id="name" v-model="fields.name" />
                    <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email" v-model="fields.email" />
                    <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label for="telefon">Telèfon</label>
                    <input type="phone" class="form-control" name="telefon" id="telefon" v-model="fields.telefon" />
                    <div v-if="errors && errors.telefon" class="text-danger">{{ errors.telefon[0] }}</div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label for="poblacio">Població</label>
                    <input type="text" class="form-control" name="poblacio" id="poblacio" v-model="fields.poblacio" />
                    <div v-if="errors && errors.poblacio" class="text-danger">{{ errors.poblacio[0] }}</div>
                </div>
            </td>
            <td>
                <div v-if="fields.id == null" class="form-group">
                    <label for="contrassenya">Contrassenya</label>
                    <input type="password" class="form-control" name="contrassenya" id="contrassenya" v-model="fields.contrassenya" />
                    <div v-if="errors && errors.contrassenya" class="text-danger">{{ errors.contrassenya[0] }}</div>
                </div>
            </td>
            <td>
                <button v-if="fields.id" v-on:click="actualitzaUsuari" class="btn btn-primary">Actualitza</button>
                <button v-if="fields.id" v-on:click="Cancelaactualitza" class="btn btn-danger">Cancela</button>
                <button v-else v-on:click="nouUsuari" class="btn btn-primary">Crear Usuari</button>
            </td>
        </table>
    </div>
</template>

<script>
    //import { myUrl } from '../config.js';
    export default {
        props: ["idUser"],
        watch: {
            'idUser': function(arMsg) {
                //obting id user a editar
                this.fields = arMsg;
            }
        },
        data () {
            return {
                searchquery: '',
                data_results: [],
                selected: '',
                dataClient: [],
                fields: {},
                errors: {},
                //url:myUrl,
                url: '',
            }
        },
        methods: {
            nouUsuari: function (event) {
                axios.post('/admin/clients/nou', this.fields).then(response => {
                    alert('Usuari Creat!');
                    this.data_results = response.data;
                    this.fields = {};
                    this.$emit('nous_usuaris', this.data_results);
                }).catch(error => {
                    if (error.response.status === 422) {
                        alert();
                    this.errors = error.response.data.errors || {};
                    }
                    if (error.response.status === 500) {
                        alert();
                    this.errors = error.response.data.errors || {};
                    }
                });
            },
            actualitzaUsuari: function (event) {
                axios.post('/admin/clients/actualitza/', this.fields).then(response => {
                    alert('Usuari Actualitzat!');
                    this.data_results = response.data;
                    this.fields = {};
                    this.$emit('nous_usuaris', this.data_results);
                }).catch(error => {
                    if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                    }
                    if (error.response.status === 500) {
                    alert("Error del servidor");
                    this.errors = error.response.data.errors || {};
                    }
                });
            },
            Cancelaactualitza: function (event) {
                this.fields = {};
            },
        },
        mounted() {
            console.log('Component Formulari Client Muntat.')
        },
    }
</script>
