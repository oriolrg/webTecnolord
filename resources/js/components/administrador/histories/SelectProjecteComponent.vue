<template>
    <div class="form-group">
        <label for="name">Projecte</label><br>
        <select v-model="selected" name="projecte" v-on:change="click" required>
        <!--  objeto literal en línea --> -->
            <option value="" @click="click">Selecciona una Projecte</option>
            <option  v-for="(result ,index) in data_results" v-bind:key="index" v-bind:value="result.id" >{{ result.name }}</option>
        </select>
    </div>
</template>

<script>
import { adminProjectesUrl } from '../../../config.js';
export default {
    data () {
        return {
            searchquery: '',
            data_results: [],
            selected: '',
            url:adminProjectesUrl,
        }
    },
    methods: {
        obtenirSelects(){
			this.visioResultats = true;
			window.axios = require('axios');

			window.axios.defaults.headers.common = {
				'X-Requested-With': 'XMLHttpRequest',
				'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			};
			this.data_results = [];
			let url = this.url+'/doing';
            //let url = "/autocomplete/categories";
			axios.get(url,{params: {searchquery: this.searchquery}}).then(response => {
                this.data_results = response.data;
			});
        },
        click(){
            //emeto l'opció selecionada
            this.$emit('clicked', this.selected);
        }
    },
    beforeMount(){
        if(this.datasecciopare != null){
            this.selected = this.datasecciopare;
        }
        this.obtenirSelects()
    },
}
</script>