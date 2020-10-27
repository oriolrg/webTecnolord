<template>
    <div class="container-fluid">
        <h1 class="mt-4">Area Administra Clients</h1>
        <div class="table-responsive">
            <nou-client-component @nous_usuaris="nous_usuaris" :idUser="idUser"></nou-client-component>
            <table class="table no-wrap user-table mb-0">
                <thead>
                <tr>
                    <th scope="col" class="border-0 text-uppercase font-medium pl-4">#</th>
                    <th scope="col" class="border-0 text-uppercase font-medium">Nom/Població</th>
                    <!--<th scope="col" class="border-0 text-uppercase font-medium">Occupation</th>-->
                    <th scope="col" class="border-0 text-uppercase font-medium">Email/Telefon</th>
                    <th scope="col" class="border-0 text-uppercase font-medium">Afegit</th>
                    <!--<th scope="col" class="border-0 text-uppercase font-medium">Category</th>-->
                    <th scope="col" class="border-0 text-uppercase font-medium">Accions</th>
                </tr>
                </thead>
                <tbody v-for="(result ,index) in data_results" v-bind:key="index" v-bind:value="result.id" @click="click">
                    <tr>
                    <td class="pl-4"></td>
                    <td>
                        <h5 class="font-medium mb-0">{{result.name}}</h5>
                        <span class="text-muted">{{result.poblacio}}</span>
                    </td>
                    <td>
                        <span class="text-muted">{{result.email}}</span><br>
                        <span class="text-muted">{{result.telefon}}</span>
                    </td>
                    <td>
                        <span class="text-muted">{{ new Date(result.created_at).getDate()}}-{{new Date(result.created_at).getMonth() + 1 }}-{{new Date(result.created_at).getFullYear()}} </span><br>
                        <span class="text-muted">
                            {{ new Date(result.created_at).getHours()}}:{{ new Date(result.created_at).getMinutes()}}
                        </span>
                    </td>
                    <td>
                        <button @click="onBorrar(result.id)" type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2"><i class="fa fa-trash"></i> </button>
                        <button @click="onEditar(result)" type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2"><i class="fa fa-edit"></i> </button>
                        <button type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2"><i class="fa fa-commenting-o "></i> </button>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    //import { myUrl } from '../config.js';
    export default {
        data () {
            return {
                searchquery: '',
                data_results: [],
                selected: '',
                dataClient: [],
                fields: {},
                errors: {},
                idUser:'',
                url: '',
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
                let url = this.url+'/admin/clients';
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
                let url = this.url+'/admin/clients/eliminar/';
                //let url = "/autocomplete/categories";
                axios.delete(url,{params: {id: id}}).then(response => {
                    this.data_results = response.data;
                });
            },
            onEditar: function(id){
                this.idUser = id;
            },
            //actualitza els usuaris
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
