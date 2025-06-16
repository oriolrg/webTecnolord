<template>
  <div id="meteoPassat" class="row" style="margin: 0.0001em;">
    <div class="col-lg-6 col-md-6"  v-for="item in rawWeatherDataPassat">
      <div class="single_blog mt-30 wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.3s">
        <div class="row" style="background-color: greenyellow;">
          <div class="col text-center">
            <span class="hora">{{ new Date(item?.dia).toLocaleString()}}</span>
          </div>
        </div>
        <div class="blog_image">
          <div class="row">
            <div class="col">
              <temperatura-component v-if="loading" 
                :temperatura="item?.data.outdoor.temperature"
                ></temperatura-component>
            </div>
            <div class="col">
              <humitat-component v-if="loading" :humitat="item?.data.outdoor"></humitat-component>
            </div>             
          </div>                        
        </div>
        <div class="blog_image">
          <div class="row">
            <div class="col">
              <pluja-component v-if="loading" :pluja="item?.data.rainfall"></pluja-component>
            </div>
          </div>
          <div class="row">
            <div class="col">              
              <vent-component v-if="loading" 
                  :vent="item?.data.wind"
                ></vent-component>
            </div>
          </div>             
        </div>   
        <div class="blog_image">
          <div class="row">
            <div class="col">
              <pressio-component v-if="loading" :pressio="item?.data.pressure"></pressio-component>
            </div>
            <div class="col">              
              <uv-component v-if="loading" :uv="item?.data.solar_and_uvi"></uv-component>
            </div>             
          </div>                        
        </div>
        <div class="blog_image">
            <div class="row">
              <div class="col">
                <rius-component v-if="loading" :rius="item?.data"></rius-component>
              </div>
              <div class="col">
                <llosa-component v-if="loading" :llosa="item?.data"></llosa-component>
              </div>             
            </div>                        
          </div>
      </div> <!-- row -->
    </div>

    <button class="botoAnterior" v-on:click="diaSeguent">Dia anterior</button>
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
      rawWeatherData: null, // resposta dades meteo api
      rawWeatherDataPassat: null, // resposta dades meteo api
      rawWeatherDataMaxMin:null,
      pagina: 1,
    }
  },
  methods: {
    diaSeguent: function () {
      this.pagina += 1;
      this.getMeteoPassat();
      window.scrollTo(0,500);
    },
    getMeteoPassat: async function() {
      var axios = require('axios'); // for handling weather api promise
      var weatherApiResponsePassat = await axios.get("http://localhost:8000/api/meteo?page="+this.pagina);
      if (weatherApiResponsePassat.status === 200) {
        this.rawWeatherDataPassat = weatherApiResponsePassat.data;
        console.log(this.rawWeatherDataPassat);
        this.loading = true
      } else {
        alert('Hmm... Hi ha algun problema de connexió!');
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


    this.getMeteoPassat();
    this.getMeteoMaxMin();
  },
};
</script>
<style>
  .hora{
    font-size: 3rem;
    text-align: center;
  }
  .col{
    padding:0.5rem;
  }
  .botoAnterior{
    font-size: 3rem;
    font-weight: bolder;
  }
</style>
