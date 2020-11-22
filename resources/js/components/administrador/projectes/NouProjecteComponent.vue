<template>
    <div>
        <table class="table no-wrap user-table mb-0">
            <td>
                <div class="form-group">
                    <label for="name">Nom Projecte</label>
                    <input type="text" class="form-control" name="name" id="name" v-model="fields.name" />
                    <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                </div>
            </td>
            <td>
                <select-clients-component @clicked="onSelectUser"></select-clients-component>
            </td>
            <td>
                <div class="form-group">
                    <label for="name">Descripcio Projecte</label>
                    <textarea type="text" class="form-control" name="descripcio" id="descripcio" v-model="fields.descripcio" />
                    <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <autocomplete-categoria-component @tags="nouTag"></autocomplete-categoria-component>
                </div>
            </td>
            <td><br>
                <button  v-if="fields.id" v-on:click="actualitza" class="btn btn-primary">Actualitza</button>
                <button  v-if="fields.id" v-on:click="Cancela" class="btn btn-danger">Cancela</button>
                <button  v-on:click="nou" class="btn btn-primary">Crear Projecte</button>
            </td>
        </table>
    </div>
</template>

<script>
    import { adminProjectesUrl } from '../../../config.js';
    export default {
        props: ["data_projecte"],
        watch: {
            'data_projecte': function(arMsg) {
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
                tags: [],
                fields: {},
                errors: {},
                url:adminProjectesUrl,
            }
        },
        methods: {
            nou: function (event) {
                let url = this.url+'/nou';
                this.fields.tags = this.tags;
                axios.post(url, this.fields).then(response => {
                    alert('Projecte Creat!');
                    this.data_results = response.data;
                    this.fields = {};
                    this.$emit('nous_usuaris', this.data_results);
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
                let url = this.url+'/actualitza';
                this.fields.tags = this.tags;
                axios.post(url, this.fields).then(response => {
                    alert('Projecte Actualitzat!');
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
                data_projecte = '';
            },
            onSelectUser (value) {
                this.fields.user_id =value;
            },
            nouTag (value) {
                this.tags = value;
            }
        },
        mounted() {
            console.log('Component Formulari Client Muntat.')
        },
    }
</script>
