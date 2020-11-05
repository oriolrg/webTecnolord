<template>
    <div class="container-fluid">
        <h1 class="mt-4">Area Administra Bugs</h1>
        <div class="table-responsive">
            <select-projecte-component @clicked="onSelectProjecte"></select-projecte-component>
        </div>
        <nou-bug-component v-if="this.projecte_id"  @noves_histories="noves_histories" :projecte_id="this.projecte_id" :data_bug="this.data_bug"></nou-bug-component>
        <b-card-group columns v-if="this.projecte_id">
            <b-card  v-for="(result ,index) in data_results" v-bind:key="index" v-bind:value="result.id" @click="click" header-tag="header" footer-tag="footer" v-bind:class="{ 'text-black bg-warning': result.estat == 0,'text-black bg-info': result.estat == 1, 'text-white bg-success': result.estat == 2}">
                <h4 class="card-title center">{{result.name}}</h4>
                <h5>Vull que faci:</h5>
                <b-card-text>{{result.que}}</b-card-text>
                <h5>Perque:</h5>
                <b-card-text>{{result.perque}}</b-card-text>
                <!--<b-button href="#" variant="primary">Go somewhere</b-button>-->
                <template v-slot:footer>
                    <em>{{ new Date(result.created_at).getDate()}}-{{new Date(result.created_at).getMonth() + 1 }}-{{new Date(result.created_at).getFullYear()}}</em>
                    <br>
                    <button class="btn btn-warning" v-if="result.estat != 0" @click="changeEstat(result.id, 0)">ToDo</button>
                    <button class="btn btn-primary" v-if="result.estat != 1" @click="changeEstat(result.id, 1)">Doing</button>
                    <button class="btn btn-success" v-if="result.estat != 2" @click="changeEstat(result.id, 2)">Done</button>
                    <br>
                    <button class="btn btn-secondary" @click="updateBug(result)"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-danger" @click="borrarBug(result.id)"><i class="fa fa-trash"></i></button>
                </template>
            </b-card>
        </b-card-group>
    </div>
</template>

<script>
    import { adminBugsUrl } from '../../../config.js';
    export default {
        //declaro la variable que passo del component fill
        data () {
            return {
                searchquery: '',
                projecte_id: '',
                data_bug:'',
                data_results: [],
                selected: '',
                url:adminBugsUrl,
            }
        },
        methods: {
            /**
            *Obtenir Projectes
            */
            obtenirBugs(){
                this.visioResultats = true;
                window.axios = require('axios');

                window.axios.defaults.headers.common = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                this.data_results = [];
                let url = '/admin/bugs';
                axios.get(url,{params: {id: this.projecte_id}}).then(response => {
                    this.data_results = response.data;
                });
            },
            //accions al seleccionar un projecte
            onSelectProjecte(id){
                this.projecte_id = id;
                this.obtenirBugs();
            },
            //accions al canviar d'estat ToDO Doing Done
            changeBug(id, estat){
                this.visioResultats = true;
                window.axios = require('axios');

                window.axios.defaults.headers.common = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                this.data_results = [];
                let url = '/admin/bugs/updateEstat';
                //let url = "/autocomplete/categories";
                axios.post(url,{id: id, estat: estat, projecte_id:this.searchquery}).then(response => {
                    this.data_results = response.data;
                });

            },
            //accions al canviar d'estat ToDO Doing Done
            changeEstat(id, estat){
                this.visioResultats = true;
                window.axios = require('axios');

                window.axios.defaults.headers.common = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                this.data_results = [];
                let url = this.url+'/updateEstat';
                //let url = "/autocomplete/categories";
                axios.post(url,{id: id, estat: estat, projecte_id:this.projecte_id}).then(response => {
                    this.data_results = response.data;
                });

            },
            click(){
                //emeto l'opció selecionada
                this.$emit('clicked', this.selected);
            },
            borrarBug: function(id){
                this.visioResultats = true;
                window.axios = require('axios');

                window.axios.defaults.headers.common = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                this.data_results = [];
                let url = '/admin/bugs/eliminar/';
                //let url = "/autocomplete/categories";
                axios.delete(url,{params: {id: id,projecte_id: this.projecte_id}}).then(response => {
                    this.data_results = response.data;
                });
            },
            //accions al clicar a editar una historia
            updateBug: function(historia){
                //id de la historia;
                this.data_bug = historia;
            },
            //actualitza les histories
            noves_histories(e){
                this.obtenirBugs();
            },
        },
        beforeMount(){
            if(this.datacategoriapare != null){
                this.selected = this.datacategoriapare;
            }
        },
        mounted() {
            console.log('Component mounted.'+this.data_results)
        }
    }
</script>
