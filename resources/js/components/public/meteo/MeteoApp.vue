<template>
  <div>
    <opcions-content></opcions-content>
    <div id="ancestor">
      <div class="container-fluid" id="app">
        <div class="row">
          <div id="sidebar" class="col-md-3 col-sm-4 col-xs-12 sidebar">
            <div id="info">
              <div class="wrapper-left">
                Temperatura:
                <div id="current-weather">
                  {{ tempsActual.temp }}
                  <span>°C</span>
                </div>
                Maxima i Mínima:
                <div id="max-detail">
                  <i>▲</i>
                  {{ tempsActual.avuiMaxMin.avuiTempMax }}
                  <span>°C</span>
                </div>
                <div id="min-detail">
                  <i>▼</i>
                  {{ tempsActual.avuiMaxMin.avuiTempMin }}
                  <span>°C</span>
                </div>
                Humitat:
                <div id="current-weather">
                  {{ tempsActual.humitat }}
                  <span>%</span>
                </div>
                Pressio:
                <div id="current-weather">
                  {{ tempsActual.pressio }}
                  <span></span>
                </div>
                Pluja acululada:
                <div id="current-weather">
                  {{ tempsActual.pluja.precipTotal }}
                  <span>l</span>
                </div>
                Intensitat pluja:
                <div id="current-weather">
                  {{ tempsActual.pluja.precipRate }}
                  <span>l h</span>
                </div>
                Punt de Rosada:
                <div id="current-weather">
                  {{ tempsActual.puntRosada }}
                  <span>°C</span>
                </div>
                Temperatura Xafogor:
                <div id="current-weather">
                  {{ tempsActual.tempXafogor }}
                  <span>°C</span>
                </div>
                Temperatura de Sensació:
                <div id="current-weather">
                  {{ tempsActual.temperaturaSensacio }}
                  <span>°C</span>
                </div>
                Index Ultravioleta:
                <div id="current-weather">
                  {{ tempsActual.uvIndex }}
                  <span>
                    {{ tempsActual.uvIndexNivell }}
                  </span>
                </div>
              </div>
            </div>
          </div>
          <dashboard-content
            class="col-md-9 col-sm-8 col-xs-12 content"
            id="dashboard-content"
            :highlights="highlights"
            :tempVar="tempVar"
          ></dashboard-content>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Content from './components/Content.vue';
import Opcions from './components/Opcions.vue';
export default {
  name: 'app',
  props: [],
  components: {
    'dashboard-content': Content,
    'opcions-content': Opcions,
  },
  data() {
    return {
      tempsActual: {
        time: '',
        temp: '',
        temperaturaSensacio: '',
        puntRosada: '',
        tempXafogor: '',
        humitat: '',
        avuiMaxMin: {
          avuiTempMax: '',
          avuiTempMaxTime: '',
          avuiTempMin: '',
          avuiTempMinTime: ''
        },
        uvIndex: '',
        uvIndexNivell: '',
        pluja: {
          precipRate: '',
          precipTotal: '',
        },
        pressio: '',
      },
      highlights: {
        windStatus: {
          windSpeed: '',
          windDirection: '',
          derivedWindDirection: '',
          windRafaga: '',
        },
      },
      tempVar: [],
      rawWeatherData: '', // resposta dades meteo api
      completeWeatherApi: '', // weather api amb la data
    }
  },
  methods: {
    calculDireccioVent: function(windDir) {
      var wind_directions_array = [
        { minVal: 0, maxVal: 30, direction: 'N' },
        { minVal: 31, maxVal: 45, direction: 'NNE' },
        { minVal: 46, maxVal: 75, direction: 'NE' },
        { minVal: 76, maxVal: 90, direction: 'ENE' },
        { minVal: 91, maxVal: 120, direction: 'E' },
        { minVal: 121, maxVal: 135, direction: 'ESE' },
        { minVal: 136, maxVal: 165, direction: 'SE' },
        { minVal: 166, maxVal: 180, direction: 'SSE' },
        { minVal: 181, maxVal: 210, direction: 'S' },
        { minVal: 211, maxVal: 225, direction: 'SSW' },
        { minVal: 226, maxVal: 255, direction: 'SW' },
        { minVal: 256, maxVal: 270, direction: 'WSW' },
        { minVal: 271, maxVal: 300, direction: 'W' },
        { minVal: 301, maxVal: 315, direction: 'WNW' },
        { minVal: 316, maxVal: 345, direction: 'NW' },
        { minVal: 346, maxVal: 360, direction: 'NNW' }
      ];
      var wind_direction = '';
      for (var i = 0; i < wind_directions_array.length; i++) {
        if (
          windDir >= wind_directions_array[i].minVal &&
          windDir <= wind_directions_array[i].maxVal
        ) {
          wind_direction = wind_directions_array[i].direction;
        }
      }
      return wind_direction;
    },
    calculIndexUV: function(uv) {
      var uv_array = [
        { minVal: 0, maxVal: 2, direction: 'Baix' },
        { minVal: 3, maxVal: 5, direction: 'Moderat' },
        { minVal: 6, maxVal: 7, direction: 'Alt' },
        { minVal: 8, maxVal: 10, direction: 'Molt alt' },
        { minVal: 11, maxVal: 120, direction: 'Extrem' },
      ];
      var uv_value = '';
      for (var i = 0; i < uv_array.length; i++) {
        if (
          uv >= uv_array[i].minVal &&
          uv <= uv_array[i].maxVal
        ) {
          uv_value = uv_array[i].direction;
        }
      }
      return uv_value;
    },
    getSetTempActual: function() {
      var currentTemp = this.rawWeatherData.dadesActuals.metric.temp;
      var currentHora = this.rawWeatherData.dadesActuals.obsTimeLocal;
      this.tempsActual.temp = currentTemp;
      this.tempsActual.time = currentHora;
      this.tempsActual.temperaturaSensacio = this.rawWeatherData.dadesActuals.metric.windGust;
      this.tempsActual.puntRosada = this.rawWeatherData.dadesActuals.metric.dewpt;
      this.tempsActual.tempXafogor = this.rawWeatherData.dadesActuals.metric.heatIndex;
      //this.tempsActual.pressio = this.rawWeatherData.dadesActuals.metric.pressure;
      this.tempsActual.humitat = this.rawWeatherData.dadesActuals.humidity;

    },
    getSetAvuiTempMinMax: function() {
      this.tempsActual.avuiMaxMin.avuiTempMax = this.rawWeatherData.TMax;
      this.tempsActual.avuiMaxMin.todayTempHighTime = this.rawWeatherData.TMax;
      this.tempsActual.avuiMaxMin.avuiTempMin = this.rawWeatherData.TMin;
      this.tempsActual.avuiMaxMin.todayTempLowTime = this.rawWeatherData.TMin;
    },
    getSetUVIndex: function() {
      var uvIndex = this.rawWeatherData.dadesActuals.uv;
      this.tempsActual.uvIndex = uvIndex;
      this.tempsActual.uvIndexNivell = this.calculIndexUV(
        uvIndex
      );
    },
    getSetVent: function() {
      var windSpeedInMiles = this.rawWeatherData.dadesActuals.metric.windSpeed;
      this.highlights.windStatus.windSpeed = windSpeedInMiles;
      var absoluteWindDir = this.rawWeatherData.dadesActuals.winddir;
      this.highlights.windStatus.windDirection = absoluteWindDir;
      this.highlights.windStatus.derivedWindDirection = this.calculDireccioVent(
        absoluteWindDir
      );
      this.highlights.windStatus.windRafaga = this.rawWeatherData.dadesActuals.metric.windGust;
    },
    getSetPluja: function() {
      this.tempsActual.pluja.precipRate = this.rawWeatherData.dadesActuals.metric.precipRate;
      this.tempsActual.pluja.precipTotal = this.rawWeatherData.dadesActuals.metric.precipTotal;
    },
    getSetPressio: function() {
      this.tempsActual.pressio = this.rawWeatherData.dadesActuals.metric.pressure;
    },
    getSetDadesDia: function() {
      this.tempVar = this.rawWeatherData.desglosDia;
    },
    urlApi: async function() {
      let url = "";
      const today = new Date();
      const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
      url = 'meteo/dia/'+date;
      var weatherApi =
        'meteo/dia/' +
        date;
      this.completeWeatherApi = weatherApi;
    },
    obtenirDadesMeteo: async function() {
      await this.urlApi();
      var axios = require('axios'); // for handling weather api promise
      var weatherApiResponse = await axios.get(this.completeWeatherApi);
      if (weatherApiResponse.status === 200) {
        this.rawWeatherData = weatherApiResponse.data;
      } else {
        alert('Hmm... Seems like our weather experts are busy!');
      }
    },
    organizeMeteoInfoActual: function() {
      // data in this.tempsActual
      /*
      Coordinates and location is covered (get & set) in:
      - this.getCoordinates()
      - this.setFormatCoordinates()
      There are lots of async-await involved there.
      So it's better to keep them there.
      */
      this.getSetTempActual();
      this.getSetAvuiTempMinMax();
      this.getSetDadesDia();
    },
    organizeAvuiHighlights: function() {
      // top level for highlights
      this.getSetUVIndex();
      this.getSetPressio();
      this.getSetPluja();
      this.getSetVent();
    },
    omplirCamps: async function() {
      // top level organization
      await this.obtenirDadesMeteo();
      this.organizeMeteoInfoActual();
      this.organizeAvuiHighlights();
      //this.getSetHourlyTempInfoToday();
    },
  },
  mounted: async function() {
    await this.omplirCamps();     
  }
};
</script>