<template>
    <div class="form-group">
        <label for="name">Client</label><br>
        <select v-model="selected" name="client" v-on:change="click" required>
        <!--  objeto literal en línea --> -->
            <option value="" @click="click">Selecciona una Client</option>
            <option  v-for="(result ,index) in data_results" v-bind:key="index" v-bind:value="result.id" >{{ result.name }}</option>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        datasecciopare: {
            type: Number,
            required: false, // my assumption
            default: null
        },
    },
    data () {
        return {
            searchquery: '',
            data_results: [],
            selected: '',
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
			let url = '/admin/clients';
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