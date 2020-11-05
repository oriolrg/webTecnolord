<template>
    <div class="container-fluid">
        <h1 class="mt-4">Area Administra Projectes Publicatss</h1>
        <div class="table-responsive">
            <table class="table no-wrap user-table mb-0">
                <thead>
                <tr>
                    <th scope="col" class="border-0 text-uppercase font-medium pl-4">#</th>
                    <th scope="col" class="border-0 text-uppercase font-medium">Nom Projecte</th>
                    <!--<th scope="col" class="border-0 text-uppercase font-medium">Occupation</th>-->
                    <th scope="col" class="border-0 text-uppercase font-medium">Client</th>
                    <th scope="col" class="border-0 text-uppercase font-medium">Tipología projecte</th>
                    <th scope="col" class="border-0 text-uppercase font-medium">Data inici</th>
                    <th scope="col" class="border-0 text-uppercase font-medium">Data Fí</th>
                    <!--<th scope="col" class="border-0 text-uppercase font-medium">Category</th>-->
                    <th scope="col" class="border-0 text-uppercase font-medium">Accions</th>
                </tr>
                </thead>
                <tbody v-for="(result ,index) in data_results" v-bind:key="index" v-bind:value="result.id" @click="click" >
                    <tr v-bind:class="{ 'table-success': result.finished_at, 'table-warning': result.finished_at == NULL}">
                    <td class="pl-4"></td>
                    <td>
                        <h5 class="font-medium mb-0">{{result.name}}</h5>
                    </td>
                    <td>
                        <span class="text-muted">{{result.user_id}}</span><br>
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
                        <span v-if="result.finished_at" class="text-muted">{{new Date(result.finished_at).getDate()}}-{{new Date(result.finished_at).getMonth() + 1 }}-{{new Date(result.finished_at).getFullYear()}} </span>
                        <span v-else class="text-muted">Doing </span><br>
                    </td>
                    <td>
                        <button @click="onPublicar(result.id)" type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2"><i class="fa fa-html5"></i> </button>
                        <button @click="onEditar(result)" type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2"><i class="fa fa-edit"></i> </button>
                        <button @click="onFinalitzar(result.id)" type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2"><i class="fa fa-calendar-check-o "></i> </button>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import { adminProjectesPublicatsUrl } from '../../../config.js';
    export default {
        data () {
            return {
                searchquery: '',
                data_results: [],
                selected: '',
                dataClient: [],
                fields: {},
                errors: {},
                data_projecte:'',
                url: adminProjectesPublicatsUrl,
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
            onBorrar: function(id){
                this.visioResultats = true;
                window.axios = require('axios');

                window.axios.defaults.headers.common = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                this.data_results = [];
                let url = this.url+'/eliminar/';
                //let url = "/autocomplete/categories";
                axios.delete(url,{params: {id: id}}).then(response => {
                    this.data_results = response.data;
                });
            },
            onPublicar: function(data_projecte){
                this.data_projecte = data_projecte;
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
                axios.post(url,{params: {id: id}}).then(response => {
                    this.data_results = response.data;
                });
            },
            //actualitza els projectes al canviar el valor del component nou projecte al fer actualitzar
            nous_usuaris(e){
                this.obtenirClients();
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
