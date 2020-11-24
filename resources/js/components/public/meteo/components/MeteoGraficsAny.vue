<template>
    <div class="centrarGrafics">
        <h1>Any</h1>
        <ejs-chart id="temperaturaAny" width='100%' height='100%' title='Temperatura' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVarAny' type='Line' xName='data' yName='temperatura' name='Temperatura'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="humitatAny" width='100%' height='350px' title='Humitat' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVarAny' type='Line' xName='data' yName='humitat' name='Humitat'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="direccioVentAny" width='100%' height='350px' title='Direcció del Vent' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVarAny' type='Line' xName='data' yName='direccio_vent' name='Direcció del Vent'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="velocitatVentAny" width='100%' height='350px' title='Velocitat del Vent' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVarAny' type='Line' xName='data' yName='velocitat_vent' name='Velocitat del Vent'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="precipitacioAny" width='100%' height='350px' title='Precipitació' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVarAny' type='Line' xName='data' yName='precipTotal' name='Precipitació'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="pressioAny" width='100%' height='350px' title='Pressió' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVarAny' type='Line' xName='data' yName='pressio' name='Pressió'> </e-series>
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
                tempVarAny: [],
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
                url = 'meteo/any/'+date;
                //let url = "/autocomplete/categories";
                axios.get(url).then(response => {
                    this.data_results = response.data;
                    this.tempVarAny = response.data.desglosAny;
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