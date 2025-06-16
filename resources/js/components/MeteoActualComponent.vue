<template>
  <div id="meteoActual" >
    <div class="col">
      <div class="single_blog mt-30 wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.3s">
          <div class="blog_image">
            <div class="row">
              <div class="col">
                <temperatura-component v-if="loading" 
                  :temperatura="rawWeatherData?.data.data.outdoor.temperature"
                  :temperaturaMax="rawWeatherDataMaxMin?.temperatura"
                  :temperaturaMin="rawWeatherDataMaxMin?.temperatura"
                ></temperatura-component>
              </div>
              <div class="col">
                <humitat-component v-if="loading" 
                  :humitat="rawWeatherData?.data.data.outdoor"                          
                  :humitatMax="rawWeatherDataMaxMin?.humitat.max"
                  :humitatMin="rawWeatherDataMaxMin?.humitat.min"
                  ></humitat-component>   
              </div>             
            </div>                        
          </div>
          <div class="blog_image">
            <div class="row">
              <div class="col">
                <pluja-component v-if="loading" :pluja="rawWeatherData?.data.data.rainfall"></pluja-component>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <vent-component v-if="loading" 
                  :vent="rawWeatherData?.data.data.wind"
                  :rafegaMax="rawWeatherDataMaxMin?.rafega"
                  :ventMax="rawWeatherDataMaxMin?.vent"
                ></vent-component> 
              </div>             
            </div>                        
          </div>
          <div class="blog_image">
            <div class="row">
              <div class="col">
                <pressio-component v-if="loading" :pressio="rawWeatherData?.data.data.pressure"></pressio-component>
              </div>
              <div class="col">
                <uv-component v-if="loading" :uv="rawWeatherData?.data.data.solar_and_uvi"></uv-component>
              </div>             
            </div>                        
          </div>
          <div class="blog_image">
            <div class="row">
              <div class="col">
                <rius-component v-if="loading" :rius="rawRiusData?.data"></rius-component>
              </div>
              <div class="col">
                <llosa-component v-if="loading" :llosa="rawRiusData?.data"></llosa-component>
              </div>             
            </div>                        
          </div>
      </div> <!-- row -->
    </div>
  </div>
</template>

<script>
import  TemperaturaComponent  from "./TemperaturaComponent.vue";
import  PressioComponent  from "./PressioComponent.vue";
import  VentComponent  from "./VentComponent.vue";
import  PlujaComponent  from "./PlujaComponent.vue";
import  HumitatComponent  from "./HumitatComponent.vue";
import  UvComponent  from "./UvComponent.vue";
export default {
  comments: {
    'temperatura-component':TemperaturaComponent,
    'pressio-component':PressioComponent,
    'vent-component':VentComponent,
    'pluja-component':PlujaComponent,
    'humitat-component':HumitatComponent,
    'uv-component':UvComponent,
  },
  name: 'app',
  props: [],
  data() {
    return {
      loading: false,
      rawRiusData: null, // resposta dades meteo api
      rawWeatherData: null, // resposta dades meteo api
      rawWeatherDataPassat: null, // resposta dades meteo api
      rawWeatherDataMaxMin:null,
      pagina: 1,
    }
  },
  methods: {
    
    urlApiMeteo: async function() {
      const url = "https://api.ecowitt.net/api/v3/device/real_time?application_key=411E5E067FA93EBE6CBB7077849A0D88&api_key=48f227ba-17e7-4b10-8e18-cc5456608048&mac=8C:AA:B5:C6:74:5F&call_back=all&temp_unitid=1&wind_speed_unitid=8&rainfall_unitid=12&pressure_unitid=3&wind_speed_unitid=7&rainfall_unitid=12";
      this.completeWeatherApi = url;
      var axios = require('axios'); // for handling weather api promise
      var weatherApiResponse = await axios.get(this.completeWeatherApi);
      if (weatherApiResponse.status === 200) {
        this.rawWeatherData = weatherApiResponse;
        this.loading = true
      } else {
        alert('Hmm... Hi ha algun problema de connexió amb ecowit!');
      }
    },
    urlApiRius: async function() {
      //$cabalRius = Http::get('http://aca-web.gencat.cat/aetr/vishid/v2/data/public/rivergauges/river_flow_6min');
        //$capacitatLlosa = Http::get('http://aca-web.gencat.cat/aetr/vishid/v2/data/public/reservoir/capacity_6min');
      const url = "http://localhost:8000/api/getCabals";
      this.completeRiusApi = url;
      var axios = require('axios'); // for handling weather api promise
      var riusApiResponse = await axios.get(this.completeRiusApi);
      if (riusApiResponse.status === 200) {
        console.log("aaaa",riusApiResponse.data);
        this.rawRiusData = riusApiResponse;
        this.loading = true
      } else {
        alert('Hmm... Hi ha algun problema de connexió amb ecowit!');
      }
    },
    getMeteoMaxMin: async function() {
      var axios = require('axios'); // for handling weather api promise
      var weatherApiResponseMaxMin = await axios.get("http://localhost:8000/api/meteoMaxMin");
      if (weatherApiResponseMaxMin.status === 200) {
        this.rawWeatherDataMaxMin = weatherApiResponseMaxMin.data;
        console.log(this.rawWeatherDataMaxMin);
        this.loading = true
      } else {
        alert('Hmm... Hi ha algun problema de connexió!');
      }
    }
  },
  async created () {

    this.urlApiMeteo();
    this.urlApiRius();
    this.getMeteoMaxMin();
  },
};
</script>