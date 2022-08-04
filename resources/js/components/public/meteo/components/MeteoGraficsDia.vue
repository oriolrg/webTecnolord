<template>
    <div id="app">
        Temperatura - Punt Rosada - Precipitacions
        <ejs-chart  id="tempprec" :primaryXAxis='primaryXAxisTRP' :primaryYAxis='primaryYAxisTRP' :axes='axesTRP' :rows='rowsTRP'  :zoomSettings='zoom' :legendSettings='legend' :crosshair='crosshair' :tooltip='tooltip'>
            <e-series-collection>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='temperatura' name='Temperatura' width=3 :marker='tempVar'> </e-series>
                <e-series :dataSource='tempVar' type='Area' xName='data' yName='precipTotal' yAxisName='yAxis' name='Precipitació' width=3 :marker='tempVar' opacity=0.5> </e-series>
            </e-series-collection>
        </ejs-chart>
        Cardener - Valls - Sortida Llosa - Capacitat Llosa
        <ejs-chart  id="container" :primaryXAxis='primaryXAxisPP' :primaryYAxis='primaryYAxisPP' :axes='axesPP' :rows='rowsPP'  :zoomSettings='zoom' :legendSettings='legend' :crosshair='crosshair' :tooltip='tooltip'>
            <e-series-collection>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='cardener' name='Cardener' width=3  :marker='tempVar'> </e-series>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='valls' name='Valls' width=3  :marker='tempVar'> </e-series>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='llosa' name='Cabal Llosa' width=3  :marker='tempVar'> </e-series>
                <e-series :dataSource='tempVar' type='Area' xName='data' yName='capacitatllosa' yAxisName='yAxis' width=3  name='Capacitat Llosa' :marker='tempVar' opacity=0.5> </e-series>
            </e-series-collection>
        </ejs-chart>
        Precipitacions
        <ejs-chart id="pluja" :primaryXAxis='primaryXAxisPP' :primaryYAxis='primaryYAxisP' :axes='axesPP' :rows='rowsPP'  :zoomSettings='zoom' :legendSettings='legend' :crosshair='crosshair' :tooltip='tooltip'>
            <e-series-collection>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='precipTotal' width=2> </e-series>
            </e-series-collection>
        </ejs-chart>
        Vent
        <ejs-chart id="vent" :primaryXAxis='primaryXAxisv' :primaryYAxis='primaryYAxisv'>
            <e-series-collection>
                <e-series :dataSource='tempVar' type='Polar' xName='direccio_vent' yName='rafega_vent' drawType='Scatter' width=2> </e-series>
            </e-series-collection>
        </ejs-chart>
        Direcció del Vent
        <ejs-chart id="direccioVentAny" width='100%' height='350px' :primaryXAxis='primaryXAxis' :primaryYAxis='primaryYAxisDV'>
            <e-series-collection>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='direccio_vent' name='Direcció del Vent' width=2> </e-series>
            </e-series-collection>
        </ejs-chart>
        Velocitat del Vent
        <ejs-chart id="velocitatVentAny" width='100%' height='350px' :primaryXAxis='primaryXAxis' :primaryYAxis='primaryYAxisVV' :crosshair='crosshair' :tooltip='tooltip'>
            <e-series-collection>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='velocitat_vent' name='Velocitat del Vent' width=2 :marker='tempVar'> </e-series>
            </e-series-collection>
        </ejs-chart>
    </div>
</template>

<script>
import { Tooltip, Legend, PolarSeries, Category, SplineSeries, RadarSeries, ChartPlugin, AreaSeries, LineSeries, DateTime, ScatterSeries, Zoom, Crosshair, StepAreaSeries} from "@syncfusion/ej2-vue-charts";


Vue.use(ChartPlugin);
export default {
    components: {},
    props: ["tempVar"],
    provide: {
        chart: [Tooltip, Legend, PolarSeries, Category, SplineSeries, RadarSeries, AreaSeries, LineSeries, DateTime, ScatterSeries, Zoom, Crosshair, StepAreaSeries]
    },
    data() {
        return {
            Tmax: '',
            Tmin: '',
            Pmax: '',
            VVmax: '',
            PRmax: '',
            PRmin: '',
            primaryXAxis: {
                valueType: 'DateTime',
                labelFormat: 'hh:mm'
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
            primaryXAxisV: {
                valueType: 'Category',
                    minimum: 0, maximum: 360, interval: 45,
                },
            primaryYAxisV: {
                minimum: 0, maximum: this.VVmax, interval: 2,
                title: 'Litres',
                labelFormat: '{value}'
            },
            primaryXAxisP: {
                valueType: 'Category',
                labelFormat: 'hh:mm'
            },
            primaryYAxisP: {
                minimum: 0, maximum: this.Pmax, interval: 10,
                title: 'Litres',
                labelFormat: '{value}'
            },
            primaryXAxisPP: {
                interval: 1,
                valueType: 'DateTime',
                labelFormat: 'hh:mm'
            },
            primaryYAxisPP: {
                minimum: 0, maximum: 2, interval: 0.1,
                lineStyle: { width: 1 },
                title: 'Cabal (m³/s)',
                labelFormat: '{value}',
                //Span for chart axis
                span: 2
            },
            axesPP:
            [
                {
                majorGridLines: { width: 0 },
                rowIndex: 0, opposedPosition: true,
                lineStyle: { width: 1 },
                minimum: 0, maximum: 100, interval: 5,
                name: 'yAxis', title: 'Capacitat (%)',
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
                labelFormat: 'hh:mm'
            },
            primaryYAxisTRP: {
                minimum: this.Tmin, maximum: this.Tmax, interval: 2,
                lineStyle: { width: 0 },
                title: 'Teemperatura',
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
        this.findMaxT(this.tempVar);
        this.findMinT(this.tempVar);
    },
};
</script>

<style>
</style>