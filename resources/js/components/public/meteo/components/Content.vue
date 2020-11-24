<template>
  <div>
    <div>
      <today-highlights :highlights="highlights"></today-highlights>
    </div>
    <div>
      <h1>Grafiques Evolució</h1>
      <meteo-grafics-diari :tempVar="tempVar"></meteo-grafics-diari>
    </div>
    <div>
      <h1>Grafiques Evolució</h1>
      <meteo-grafics-mes></meteo-grafics-mes>
    </div>
    <div>
      <h1>Grafiques Evolució</h1>
      <meteo-grafics-any></meteo-grafics-any>
    </div>
  </div>
</template>

<script>
import MeteoGraficsDiari from './MeteoGraficsDia.vue';
import MeteoGraficsMes from './MeteoGraficsMes.vue';
import MeteoGraficsAny from './MeteoGraficsAny.vue';
import Highlights from './Highlights.vue';
export default {
  props: ['highlights', 'tempVar'],
  components: {
    'meteo-grafics-diari': MeteoGraficsDiari,
    'meteo-grafics-mes': MeteoGraficsMes,
    'meteo-grafics-any': MeteoGraficsAny,
    'today-highlights': Highlights
  },
}
</script>