<template>
    <div class="centrarGrafics">
        <h1>Grafiques Evolució</h1>
        <h1>Mes</h1>
        <ejs-chart id="temperaturaMes" width='100%' height='100%' title='Temperatura' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='temperatura' name='Temperatura'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="direccioVentMes" width='100%' height='350px' title='Direcció del Vent' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='direccio_vent' name='Direcció del Vent'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="precipitacioMes" width='100%' height='350px' title='Precipitació' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='precipTotal' name='Precipitació'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="pressioMes" width='100%' height='350px' title='Pressió' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='pressio' name='Pressió'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="humitatMes" width='100%' height='350px' title='Humitat' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='humitat' name='Humitat'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="velocitatVentMes" width='100%' height='350px' title='Velocitat del Vent' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='velocitat_vent' name='Velocitat del Vent'> </e-series>
            </e-series-collection>
        </ejs-chart>
    </div>
</template>

<script>
import { ChartPlugin, ColumnSeries, Category, LineSeries, DateTimeCategory, DateTime  } from "@syncfusion/ej2-vue-charts";

Vue.use(ChartPlugin);
export default {
    components: {},
        provide: {
            chart: [ColumnSeries, Category,LineSeries, DateTimeCategory, DateTime]
        },
        data() {
            return {
                tempVarMes: [],
                primaryXAxis: {
                        valueType: 'DateTime',
                        labelFormat: 'dd/MM/yy'
                },
            };
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
                url = 'meteo/mes/'+(today.getMonth()+1)+'/any/'+ today.getFullYear();
                //let url = "/autocomplete/categories";
                axios.get(url).then(response => {
                    this.data_results = response.data;
                    this.tempVarMes = response.data.desglosMes;
                });
            },
        },
        beforeMount(){
            this.obtenirDadesInicials();
        },
    };
</script>

<style>
</style>