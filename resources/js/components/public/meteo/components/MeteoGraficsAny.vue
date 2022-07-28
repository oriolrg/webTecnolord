<template>
    <div id="app">
        Precipitacions Diaries
        <ejs-chart  id="precipitacioTotal" :primaryXAxis='primaryXAxisP'  :axes='axesP' :rows='rowsTRP'  :zoomSettings='zoom' :legendSettings='legend' :crosshair='crosshair' :tooltip='tooltip'>
            <e-series-collection>
                <e-series :dataSource='tempVarAny' type='Line' xName='data' yName='precipTotal' name='Precipitació' :marker='tempVarAny'> </e-series>
            </e-series-collection>
        </ejs-chart>
        Precipitacio Acomulada
        <ejs-chart  id="precipitacioAcum" :primaryXAxis='primaryXAxisP'  :axes='axesP' :rows='rowsTRP'  :zoomSettings='zoom' :legendSettings='legend' :crosshair='crosshair' :tooltip='tooltip'>
            <e-series-collection>
                <e-series :dataSource='tempVarAny' type='Line' xName='data' yName='precipAcumulada' name='Precipitació Acomulada' :marker='tempVarAny'> </e-series>
            </e-series-collection>
        </ejs-chart>
        Temperatura Max i mín
        <ejs-chart  id="container" :primaryXAxis='primaryXAxisPP' :primaryYAxis='primaryYAxisPP' :axes='axesPP' :rows='rowsPP' :zoomSettings='zoom' :legendSettings='legend' :crosshair='crosshair' :tooltip='tooltip'>
            <e-series-collection>
                <e-series :dataSource='tempVarAny' type='Line' xName='data' yName='TMin' name='Temperatura Min' :marker='tempVarAny'> </e-series>
                <e-series :dataSource='tempVarAny' type='Line' xName='data' yName='TMax' name='Temperatura Max' :marker='tempVarAny'> </e-series>
            </e-series-collection>
        </ejs-chart>
    </div>
</template>

<script>
import { Tooltip, Legend, PolarSeries, Category, SplineSeries, RadarSeries, ChartPlugin, AreaSeries, LineSeries, DateTime, Zoom, Crosshair} from "@syncfusion/ej2-vue-charts";


Vue.use(ChartPlugin);
export default {
    components: {},
    provide: {
        chart: [Tooltip, Legend, PolarSeries, Category, SplineSeries, RadarSeries, AreaSeries, LineSeries, DateTime, Zoom, Crosshair]
    },
    data() {
        return {
            Tmax: '',
            Tmin: '',
            Pmax: '',
            VVmax: '',
            PRmax: '',
            PRmin: '',
            tempVarAny: [],
            primaryXAxis: {
                valueType: 'DateTime',
                labelFormat: 'MMM'
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
                labelFormat: 'MMM'
            },
            primaryYAxisPP: {
                minimum: this.Tmin, maximum: this.Tmax, interval: 2,
                lineStyle: { width: 2 },
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
                labelFormat: 'MMM'
            },
            primaryYAxisTRP: {
                minimum: this.Tmin, maximum: this.Tmax, interval: 2,
                lineStyle: { width: 0 },
                title: 'Teemperatura / Punt de Rosada',
                labelFormat: '{value}C',
                //Span for chart axis
                span: 2
            },
            axesP:
            [
                {
                majorGridLines: { width: 0 },
                rowIndex: 0, opposedPosition: true,
                lineStyle: { width: 0 },
                minimum: 0, maximum: 600, interval: 5,
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
            zoom:
            {
                enableMouseWheelZooming: true,
                enablePinchZooming: true,
                enableSelectionZooming: true
            },
            crosshair: {  enable: true, lineType: 'Vertical' },
            tooltip: { enable: true, shared: true, format: '${series.name} : ${point.x} : ${point.y}' },
            marker: { visible: true }
        };
    },
    methods: {
        findMaxT(topConfirmed) {
            let findTop = [];
            topConfirmed.forEach(obj => findTop.push(obj.Tmax));
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
            topConfirmed.forEach(obj => findTop.push(obj.Tmin));
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
            url = 'meteo/any/'+date;
            this.temperatures + date;
            //let url = "/autocomplete/categories";
            axios.get(url).then(response => {
                this.data_results = response.data;
                this.tempVarAny = response.data.desglosAny;
            });
        },
    },
    beforeMount(){
        this.obtenirDadesInicials();
        this.findMaxT(this.tempVarAny);
        this.findMinT(this.tempVarAny);
    },
};
</script>

<style>
</style>