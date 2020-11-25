<template>
  <div>
    <opcions-content @selecting="updateSelected"></opcions-content>
    <div>
      <meteo-grafics-diari v-if="selected === '' || selected === 'actuals'" :tempVar="tempVar"></meteo-grafics-diari>
    </div>
    <div>
      <meteo-grafics-mes v-if="selected === 'mensuals'"></meteo-grafics-mes>
    </div>
    <div>
      <meteo-grafics-any v-if="selected === 'anuals'"></meteo-grafics-any>
    </div>
  </div>
</template>

<script>
import MeteoGraficsDiari from './MeteoGraficsDia.vue';
import MeteoGraficsMes from './MeteoGraficsMes.vue';
import MeteoGraficsAny from './MeteoGraficsAny.vue';
import Opcions from './Opcions.vue';
export default {
  props: ['highlights', 'tempVar'],
  components: {
    'meteo-grafics-diari': MeteoGraficsDiari,
    'meteo-grafics-mes': MeteoGraficsMes,
    'meteo-grafics-any': MeteoGraficsAny,
    'opcions-content': Opcions,
  },
  data () {
        return {
            selected: '',
        }
    },
  methods: {
    updateSelected(newValue) {
      this.selected = newValue;
    }
  }
}
</script>