<template>
    <div class="container-fluid">
        <h1 class="mt-4">Area Administra Projectes Publicatss</h1>
        <div class="table-responsive">
            <table class="table no-wrap user-table mb-0">
                <thead>
                <tr>
                    <th scope="col" class="border-0 text-uppercase font-medium pl-4">#</th>
                    <th scope="col" class="border-0 text-uppercase font-medium">Nom Projecte</th>
                    <th scope="col" class="border-0 text-uppercase font-medium">Tipología projecte</th>
                    <th scope="col" class="border-0 text-uppercase font-medium">Data inici</th>
                    <th scope="col" class="border-0 text-uppercase font-medium">Data Fí</th>
                    <th scope="col" class="border-0 text-uppercase font-medium">Accions</th>
                </tr>
                </thead>
                <tbody v-for="(result ,index) in data_results" v-bind:key="index" v-bind:value="result.id" @click="click" >
                    <tr v-bind:class="{ 'table-success': result.publicat == 1, 'table-warning': result.publicat == 0}">
                    <td class="pl-4"></td>
                    <td>
                        <h5 class="font-medium mb-0">{{result.name}}</h5>
                    </td>
                    <td>
                        <span class="text-muted">{{result.descripcio}} </span><br>
                    </td>
                    <td>
                        <span class="text-muted">{{ new Date(result.created_at).getDate()}}-{{new Date(result.created_at).getMonth() + 1 }}-{{new Date(result.created_at).getFullYear()}} </span><br>
                        <span class="text-muted">
                            {{ new Date(result.created_at).getHours()}}:{{ new Date(result.created_at).getMinutes()}}
                        </span>
                    </td>
                    <td>
                        <span v-if="result.publicat == 1" class="text-muted">Publicat </span>
                        <span v-else class="text-muted">Per publicar </span><br>
                    </td>
                    <td>
                        <button @click="onPublicar(result.id)" type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2"><i class="fa fa-html5"></i> </button>
                        <button @click="onFinalitzar(result.id)" type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2"><i class="fa fa-window-close-o "></i> </button>
                        <button @click="onEditar(result)" type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2"><i class="fa fa-edit"></i> </button>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="this.show_form==true" class="" id="create">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>{{data_editar.name}}</h4>
                        <button @click="onTancar()" type="button" class="close" data-dismiss="modal">
                            <span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nom Projecte:</label>
                            <textarea type="text" class="form-control" name="name" id="name" v-model="data_editar.name" />
                            <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                        </div>
                        <div class="form-group">
                            <label for="name">Descripcio:</label>
                            <textarea type="text" class="form-control" name="descripcio" id="descripcio" v-model="data_editar.descripcio" />
                            <div v-if="errors && errors.descripcio" class="text-danger">{{ errors.descripcio[0] }}</div>
                        </div>
                        <div class="form-group">
                            <label for="name">Tipologia Projecte:</label>
                            <textarea type="text" class="form-control" name="tipologia" id="tipologia" v-model="data_editar.tipologia" />
                            <div v-if="errors && errors.tipologia" class="text-danger">{{ errors.tipologia[0] }}</div>
                        </div>
                        <input type="file" @change="selectFile">
                    </div>
                    <div class="modal-footer">
                        <button @click="onGuardarProjecteEditat(data_editar)" type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2"><i class="fa fa-save"> Guardar</i> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { adminProjectesPublicatsUrl } from '../../../config.js';
    export default {
        data () {
            return {
                photo: null,
                searchquery: '',
                data_results: [],
                selected: '',
                dataClient: [],
                fields: {},
                errors: {},
                data_projecte:'',
                show_form:'',
                url: adminProjectesPublicatsUrl,
                data_editar: [],
            }
        },
        methods: {
            /**
            *Obtenir Usuaris
            */
            obtenirClients(){
                this.visioResultats = true;
                window.axios = require('axios');
                window.axios.defaults.headers.common = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                this.data_results = [];
                let url = this.url;
                //let url = "/autocomplete/categories";
                axios.get(url,{params: {searchquery: this.searchquery}}).then(response => {
                    this.data_results = response.data;
                });
            },
            onPublicar: function(id){
                this.visioResultats = true;
                window.axios = require('axios');

                window.axios.defaults.headers.common = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                let url = this.url+'/nou/';
                this.data_results = [];
                axios.get(url,{params: {id: id}}).then(response => {
                    this.data_results = response.data;
                });
            },
            onFinalitzar: function(id){
                window.axios = require('axios');

                window.axios.defaults.headers.common = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                this.data_results = [];
                let url = this.url+'/finalitzar/';
                //let url = "/autocomplete/categories";
                axios.get(url,{params: {id: id}}).then(response => {
                    this.data_results = response.data;
                });
            },
            onEditar: function(result){
                this.data_editar = [];
                this.data_editar = result;
                this.show_form = true;
            },
            onGuardarProjecteEditat: function(){

            },
            onTancar: function(){
                this.show_form = false;
            },
            selectFile(event) {
                // `files` is always an array because the file input may be in multiple mode
                this.photo = event.target.files[0];
            },
            click(){
                //emeto l'opció selecionada
                this.$emit('clicked', this.selected);
            }
        },
        beforeMount(){
            if(this.datacategoriapare != null){
                this.selected = this.datacategoriapare;
            }
            this.obtenirClients()
        },
        mounted() {
            console.log('Component mounted.'+this.data_results)
        }
    }
</script>
