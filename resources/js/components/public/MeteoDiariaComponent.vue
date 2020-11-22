<template>
<div>
     <ejs-chart id="temperaturaDiaria" width='100%' height='100%' :title='title' :primaryXAxis='primaryXAxis'>
        <e-series-collection>
            <e-series :dataSource='seriesData' type='Line' xName='data' yName='temperatura' name='Temperatura'> </e-series>
        </e-series-collection>
    </ejs-chart>
    <ejs-chart id="humitatDiaria" width='100%' height='350px' :title='titlehumitat' :primaryXAxis='primaryXAxis'>
        <e-series-collection>
            <e-series :dataSource='seriesData' type='Line' xName='data' yName='humitat' name='Humitat'> </e-series>
        </e-series-collection>
    </ejs-chart>
    <ejs-chart id="direccioVentDiaria" width='100%' height='350px' title='Direcció del Vent' :primaryXAxis='primaryXAxis'>
        <e-series-collection>
            <e-series :dataSource='seriesData' type='Line' xName='data' yName='direccio_vent' name='Direcció del Vent'> </e-series>
        </e-series-collection>
    </ejs-chart>
    <ejs-chart id="velocitatVentDiaria" width='100%' height='350px' title='Velocitat del Vent' :primaryXAxis='primaryXAxis'>
        <e-series-collection>
            <e-series :dataSource='seriesData' type='Line' xName='data' yName='velocitat_vent' name='Velocitat del Vent'> </e-series>
        </e-series-collection>
    </ejs-chart>
    <ejs-chart id="precipitacioDiaria" width='100%' height='350px' title='Precipitació' :primaryXAxis='primaryXAxis'>
        <e-series-collection>
            <e-series :dataSource='seriesData' type='Line' xName='data' yName='precipTotal' name='Precipitació'> </e-series>
        </e-series-collection>
    </ejs-chart>
    <ejs-chart id="pressioDiaria" width='100%' height='350px' title='Pressió' :primaryXAxis='primaryXAxis'>
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

                labelFormat: 'hh:mm'
            },
            title: "Temperatura",
            titlehumitat: "Humitat",
            data_results: [],
        }
    },
    provide: {
        chart: [ColumnSeries, Category,LineSeries, DateTimeCategory, DateTime]
    },
    methods: {
        obtenirDadesInicials(){
			window.axios = require('axios');
			window.axios.defaults.headers.common = {
				'X-Requested-With': 'XMLHttpRequest',
				'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };
            let url = "";
            const today = new Date();
            const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            url = 'meteo/dia/'+date;
            //let url = "/autocomplete/categories";
            axios.get(url).then(response => {
                this.data_results = response.data;
                this.seriesData = response.data.desglosDia
            });
        }
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