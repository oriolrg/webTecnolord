<template>
    <div>
                <div class="form-group card-columns">
                    <label for="name">Titol Historia:</label>
                    <textarea type="text" class="form-control" name="name" id="name" v-model="fields.name" />
                    <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                </div>
                <div class="form-group card-columns">
                    <label for="name">Que passa:</label>
                    <textarea type="text" class="form-control" name="que" id="que" v-model="fields.que" />
                    <div v-if="errors && errors.que" class="text-danger">{{ errors.que[0] }}</div>
                </div>
                <div class="form-group card-columns">
                    <label for="name">Que hauria de passar:</label>
                    <textarea type="text" class="form-control" name="perque" id="perque" v-model="fields.perque" />
                    <div v-if="errors && errors.perque" class="text-danger">{{ errors.perque[0] }}</div>
                </div>
                <div class="form-group card-columns">
                <button  v-if="fields.id" v-on:click="actualitza" class="btn btn-primary">Actualitza</button>
                <button  v-if="fields.id" v-on:click="Cancela" class="btn btn-danger">Cancela</button>
                <button  v-else v-on:click="nou" class="btn btn-primary">Crear Bug</button>
            </div>
    </div>
</template>

<script>
    import { clientsBugsUrl } from '../../../config.js';
    export default {
        //declaro la propietat que rebo del component pare projecte_id
        props: {
            projecte_id:Number,
            data_bug:Object,
        },
        watch: {
            'data_bug': function(arMsg) {
                //obting id user a editar
                this.fields = arMsg;
            }
        },
        data () {
            return {
                data_results: [],
                fields: {},
                errors: {},
                url: clientsBugsUrl,
            }
        },
        methods: {
            nou: function (event) {
                this.fields.id = this.projecte_id;
                this.data_results = [];
                axios.post(this.url + '/nou', this.fields).then(response => {
                    alert('Bug Creat!');
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
                    alert('Bug Actualitzat!');
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
            Cancela: function (event) {
                this.fields = {};
            },
        },
        mounted() {
            console.log('Component Formulari Client Muntat.')
        },
    }
</script>
