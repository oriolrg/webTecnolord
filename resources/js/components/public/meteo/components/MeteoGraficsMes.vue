<template>
    <div class="centrarGrafics">
        <h1>Mes</h1>
        <ejs-chart id="temperaturaMes" width='100%' height='100%' title='Temperatura' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='temperatura' name='Temperatura'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="humitatAny" width='100%' height='350px' title='Humitat' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='humitat' name='Humitat'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="direccioVentAny" width='100%' height='350px' title='Direcció del Vent' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='direccio_vent' name='Direcció del Vent'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="velocitatVentMes" width='100%' height='350px' title='Velocitat del Vent' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='velocitat_vent' name='Velocitat del Vent'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="precipitacioAny" width='100%' height='350px' title='Precipitació' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='precipTotal' name='Precipitació'> </e-series>
            </e-series-collection>
        </ejs-chart>
        <ejs-chart id="pressioAny" width='100%' height='350px' title='Pressió' :primaryXAxis='primaryXAxis'>
            <e-series-collection>
                <e-series :dataSource='tempVar' type='Line' xName='data' yName='pressio' name='Pressió'> </e-series>
            </e-series-collection>
        </ejs-chart>
    </div>
</template>

<script>
import { ChartPlugin, ColumnSeries, Category, LineSeries, DateTimeCategory, DateTime  } from "@syncfusion/ej2-vue-charts";

Vue.use(ChartPlugin);
export default {
  props: ["tempVar"],
  components: {},
    provide: {
        chart: [ColumnSeries, Category,LineSeries, DateTimeCategory, DateTime]
    },
  data() {
    return {
      seriesData: [],
            primaryXAxis: {
                valueType: 'DateTime',

                labelFormat: 'hh:mm'
            },
    };
  },
  methods: {
  },
};
</script>

<style>
</style>