<template>
<div>
    <select v-model="selectedmes" name="mes" v-on:change="obtenirDadesMesAny" required>
        <!--  objeto literal en línea --> -->
            <option>Selecciona el mes</option>
            <option  v-for="(result ,index) in mesos" v-bind:key="index" v-bind:value="result" >{{ result.name }}</option>
    </select>
    <select v-model="selectedany" name="any" v-on:change="obtenirDadesMesAny" required>
        <!--  objeto literal en línea --> -->
            <option>Selecciona l'any</option>
            <option  v-for="(n ,index) in 100" v-bind:key="index" v-bind:value="n + 2019" >{{ n + 2019 }}</option>
    </select>
     <ejs-chart id="temperaturaMes" width='100%' height='100%' :title='title' :primaryXAxis='primaryXAxis'>
        <e-series-collection>
            <e-series :dataSource='seriesData' type='Line' xName='data' yName='temperatura' name='Temperatura'> </e-series>
        </e-series-collection>
    </ejs-chart>
    <ejs-chart id="humitatMes" width='100%' height='350px' :title='titlehumitat' :primaryXAxis='primaryXAxis'>
        <e-series-collection>
            <e-series :dataSource='seriesData' type='Line' xName='data' yName='humitat' name='Humitat'> </e-series>
        </e-series-collection>
    </ejs-chart>
    <ejs-chart id="direccioVentMes" width='100%' height='350px' title='Direcció del Vent' :primaryXAxis='primaryXAxis'>
        <e-series-collection>
            <e-series :dataSource='seriesData' type='Line' xName='data' yName='direccio_vent' name='Direcció del Vent'> </e-series>
        </e-series-collection>
    </ejs-chart>
    <ejs-chart id="velocitatVentMes" width='100%' height='350px' title='Velocitat del Vent' :primaryXAxis='primaryXAxis'>
        <e-series-collection>
            <e-series :dataSource='seriesData' type='Line' xName='data' yName='velocitat_vent' name='Velocitat del Vent'> </e-series>
        </e-series-collection>
    </ejs-chart>
    <ejs-chart id="precipitacioMes" width='100%' height='350px' title='Precipitació' :primaryXAxis='primaryXAxis'>
        <e-series-collection>
            <e-series :dataSource='seriesData' type='Line' xName='data' yName='precipTotal' name='Precipitació'> </e-series>
        </e-series-collection>
    </ejs-chart>
    <ejs-chart id="pressioMes" width='100%' height='350px' title='Pressió' :primaryXAxis='primaryXAxis'>
        <e-series-collection>
            <e-series :dataSource='seriesData' type='Line' xName='data' yName='pressio' name='Pressió'> </e-series>
        </e-series-collection>
    </ejs-chart>
</div>
</template>

<script>
import { mesos } from '../../config.js';
import { ChartPlugin, ColumnSeries, Category, LineSeries, DateTimeCategory, DateTime  } from "@syncfusion/ej2-vue-charts";

Vue.use(ChartPlugin);
export default {
    data () {
        return {
            seriesData: [],
            primaryXAxis: {
                valueType: 'DateTime',

                labelFormat: 'dd/MM/yy'
            },
            title: "Temperatura",
            titlehumitat: "Humitat",
            data_results: [],
            selectedmes: [],
            selectedany: [],
            mesos: [{
                    name : 'Gener',
                    id : 1},
                {
                    name : 'Febrer',
                    id : 2},
                {
                    name : 'Març',
                    id : 3},
                {
                    name : 'Abril',
                    id : 4},
                {
                    name : 'Maig',
                    id : 5},
                {
                    name : 'Juny',
                    id : 6},
                {
                    name : 'Juliol',
                    id : 7},
                {
                    name : 'Agost',
                    id : 8},
                {
                    name : 'Setembre',
                    id : 9},
                {
                    name : 'Octubre',
                    id : 10},
                {
                    name : 'Novembre',
                    id : 11},
                {
                    name : 'Desembre',
                    id : 12},
            ]
        }
    },
    provide: {
        chart: [ColumnSeries, Category,LineSeries, DateTimeCategory, DateTime]
    },
    methods: {
        obtenirDadesMesAny(){
			window.axios = require('axios');
			window.axios.defaults.headers.common = {
				'X-Requested-With': 'XMLHttpRequest',
				'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };
            let url = "";
            if(this.selectedany){
                url = 'meteo/any/'+this.selectedany;
                //let url = "/autocomplete/categories";
                axios.get(url).then(response => {
                    this.data_results = response.data;
                    this.seriesData = response.data.desglosAny
                });
            }
            if(this.selectedmes.id && this.selectedany){
                url = 'meteo/mes/'+this.selectedmes.id+'/any/'+this.selectedany;
                //let url = "/autocomplete/categories";
                axios.get(url).then(response => {
                    this.data_results = response.data;
                    this.seriesData = response.data.desglosMes
                });
            }
            
            
        },
        obtenirDadesInicials(){
			window.axios = require('axios');
			window.axios.defaults.headers.common = {
				'X-Requested-With': 'XMLHttpRequest',
				'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };
            let url = "";
            const today = new Date();
            const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            url = 'meteo/mes/'+(today.getMonth()+1)+'/any/'+date;
            //let url = "/autocomplete/categories";
            axios.get(url).then(response => {
                this.data_results = response.data;
                this.seriesData = response.data.desglosMes
            });
            
            
        },
    },
    beforeMount(){
        this.obtenirDadesInicials();
    },
}
</script>
<style>
 #container {
    height: 100%;
    width: 100%;
 }
</style>