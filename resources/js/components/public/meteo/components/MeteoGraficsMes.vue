<template>
    <div id="app">
        Temperatura - Punt Rosada - Precipitacions
        <ejs-chart  id="tempprec" :primaryXAxis='primaryXAxisTRP' :primaryYAxis='primaryYAxisTRP' :axes='axesTRP' :rows='rowsTRP'>
            <e-series-collection>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='temperatura' name='Temperatura'> </e-series>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='precipTotal' yAxisName='yAxis' name='Precipitació'> </e-series>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='punt_rosada' name='Punt de Rosada'> </e-series>
            </e-series-collection>
        </ejs-chart>
        Precipitacions - Humitat - Pressió
        <ejs-chart  id="container" :primaryXAxis='primaryXAxisPP' :primaryYAxis='primaryYAxisPP' :axes='axesPP' :rows='rowsPP'>
            <e-series-collection>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='precipTotal' name='Precipitació'> </e-series>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='pressio' yAxisName='yAxis' name='Pressió'> </e-series>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='humitat' name='Humitat'> </e-series>
            </e-series-collection>
        </ejs-chart>
        Precipitacions
        <ejs-chart id="pluja" :primaryXAxis='primaryXAxisP' :primaryYAxis='primaryYAxisP'>
            <e-series-collection>
                <e-series :dataSource='tempVarMes' type='Polar' xName='data' yName='precipTotal' drawType='Area'> </e-series>
            </e-series-collection>
        </ejs-chart>
        Direcció del Vent
        <ejs-chart id="direccioVentAny" width='100%' height='350px' :primaryXAxis='primaryXAxis' :primaryYAxis='primaryYAxisDV'>
            <e-series-collection>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='direccio_vent' name='Direcció del Vent'> </e-series>
            </e-series-collection>
        </ejs-chart>
        Velocitat del Vent
        <ejs-chart id="velocitatVentAny" width='100%' height='350px' :primaryXAxis='primaryXAxis' :primaryYAxis='primaryYAxisVV'>
            <e-series-collection>
                <e-series :dataSource='tempVarMes' type='Line' xName='data' yName='velocitat_vent' name='Velocitat del Vent'> </e-series>
            </e-series-collection>
        </ejs-chart>
    </div>
</template>

<script>
import { Tooltip, Legend, PolarSeries, Category, SplineSeries, RadarSeries, ChartPlugin, AreaSeries, LineSeries, DateTime} from "@syncfusion/ej2-vue-charts";


Vue.use(ChartPlugin);
export default {
    components: {},
    provide: {
        chart: [Tooltip, Legend, PolarSeries, Category, SplineSeries, RadarSeries, AreaSeries, LineSeries, DateTime]
    },
    data() {
        return {
            Tmax: '',
            Tmin: '',
            Pmax: '',
            VVmax: '',
            PRmax: '',
            PRmin: '',
            tempVarMes: [],
            primaryXAxis: {
                valueType: 'DateTime',
                labelFormat: 'dd/MM/yy'
            },
            primaryYAxisDV: {
                minimum: 0, maximum: 360, interval: 30,
                title: 'Direccio del Vent',
                labelFormat: '{value}º',
            },
            primaryYAxisVV: {
                minimum: 0, maximum: this.VVmax, interval: 2,
                title: 'Velocitat del Vent',
                labelFormat: '{value}km/h',
            },
            primaryXAxisP: {
                valueType: 'Category'
            },
            primaryYAxisP: {
                minimum: 0, maximum: this.Pmax, interval: 10,
                title: 'Litres',
                labelFormat: '{value}'
            },
            primaryXAxisPP: {
                valueType: 'DateTime',
                labelFormat: 'dd/MM/yy'
            },
            primaryYAxisPP: {
                minimum: 0, maximum: 100, interval: 10,
                lineStyle: { width: 0 },
                title: 'Precipitació(l)/Humitat(%)',
                labelFormat: '{value}',
                //Span for chart axis
                span: 2
            },
            axesPP:
            [
                {
                majorGridLines: { width: 0 },
                rowIndex: 0, opposedPosition: true,
                lineStyle: { width: 0 },
                minimum: this.PRmin, maximum: this.PRmax, interval: 1,
                name: 'yAxis', title: 'Pressió',
                labelFormat: '{value}'
                }
            ],
            rowsPP:[
                {
                    height: '100%'
                },{
                    height: '100%'
                }
            ],
            primaryXAxisTRP: {
                valueType: 'DateTime',
                labelFormat: 'dd/MM/yy'
            },
            primaryYAxisTRP: {
                minimum: this.Tmin, maximum: this.Tmax, interval: 2,
                lineStyle: { width: 0 },
                title: 'Teemperatura / Punt de Rosada',
                labelFormat: '{value}C',
                //Span for chart axis
                span: 2
            },
            axesTRP:
            [
                {
                majorGridLines: { width: 0 },
                rowIndex: 0, opposedPosition: true,
                lineStyle: { width: 0 },
                minimum: 0, maximum: this.Pmax, interval: 5,
                name: 'yAxis', title: 'Precipitació',
                labelFormat: '{value}'
                }
            ],
            rowsTRP:[
                {
                    height: '100%'
                },{
                    height: '100%'
                }
            ],
        };
    },
    methods: {
        findMaxT(topConfirmed) {
            let findTop = [];
            topConfirmed.forEach(obj => findTop.push(obj.temperatura));
            this.Tmax = Math.max(...findTop);
            findTop = [];
            topConfirmed.forEach(obj => findTop.push(obj.precipTotal));
            this.Pmax = Math.max(...findTop);
            findTop = [];
            topConfirmed.forEach(obj => findTop.push(obj.pressio));
            this.PRmax = Math.max(...findTop);
            findTop = [];
            topConfirmed.forEach(obj => findTop.push(obj.velocitat_vent));
            this.VVmax = Math.max(...findTop);
        },
        findMinT(topConfirmed) {
            let findTop = [];
            topConfirmed.forEach(obj => findTop.push(obj.temperatura));
            this.Tmin = Math.min(...findTop);findTop = [];
            topConfirmed.forEach(obj => findTop.push(obj.temperpressioatura));
            this.PRmin = Math.min(...findTop);
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
        this.findMaxT(this.tempVarMes);
        this.findMinT(this.tempVarMes);
    },
};
</script>

<style>
</style>