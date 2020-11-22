<template>
    <div class="form-group">
        <label for="name">Projecte</label><br>
        <select v-model="selected" name="projecte" v-on:change="click" required>
        <!--  objeto literal en línea --> -->
            <option value="" @click="click">Selecciona una Projecte</option>
            <option  v-for="(result ,index) in data_results" v-bind:key="index" v-bind:value="result" >{{ result.name }}</option>
        </select>
        <ul v-if="this.selected.descripcio">
            <li class="list-group-item">
                <h3 class="mt-4">Descripció del Projecte</h3>
                <p>{{this.selected.descripcio}}</p>
            </li>
        </ul>
    </div>
</template>

<script>
import { clientsProjectesUrl } from '../../../config.js';
export default {
    data () {
        return {
            searchquery: '',
            data_results: [],
            selected: '',
            url:clientsProjectesUrl,
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
			let url = this.url+'';
            //let url = "/autocomplete/categories";
			axios.get(url).then(response => {
                this.data_results = response.data;
			});
        },
        click(){
            //emeto l'opció selecionada
            this.$emit('clicked', this.selected.id);
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