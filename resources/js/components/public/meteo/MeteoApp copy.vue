<template>
  <div id="ancestor">
    <div class="container-fluid" id="app">
      <div class="row">
        <div id="sidebar" class="col-md-3 col-sm-4 col-xs-12 sidebar">
          <div id="search">
            <input
              id="location-input"
              type="text"
              ref="input"
              placeholder="Location?"
            >
            <button id="search-btn" >
              <img src="./assets/Search.svg" width="24" height="24">
            </button>
          </div>
          <div id="info">
            <div class="wrapper-left">
              <div id="current-weather">
                {{ currentWeather.temp }}
                <span>°C</span>
              </div>
              <div id="weather-desc">{{ currentWeather.summary }}</div>
              <div class="temp-max-min">
                <div class="max-desc">
                  <div id="max-detail">
                    <i>▲</i>
                    {{ currentWeather.todayHighLow.todayTempHigh }}
                    <span>°C</span>
                  </div>
                  <div id="max-summary">at {{ currentWeather.todayHighLow.todayTempHighTime }}</div>
                </div>
                <div class="min-desc">
                  <div id="min-detail">
                    <i>▼</i>
                    {{ currentWeather.todayHighLow.todayTempLow }}
                    <span>°C</span>
                  </div>
                  <div id="min-summary">at {{ currentWeather.todayHighLow.todayTempLowTime }}</div>
                </div>
              </div>
            </div>
            <div class="wrapper-right">
              <div class="date-time-info">
                <div id="date-desc">
                  <img src="./assets/calendar.svg" width="20" height="20">
                  {{ currentWeather.time }}
                </div>
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
</template>

<script>
import Content from './components/Content.vue';
export default {
  name: 'app',
  props: [],
  components: {
    'dashboard-content': Content
  },
  data() {
    return {
      weatherDetails: false,
      completeWeatherApi: '', // weather api string with lat and long
      rawWeatherData: '', // raw response from weather api
      currentWeather: {
        time: '',
        temp: '',
        todayHighLow: {
          todayTempHigh: '',
          todayTempHighTime: '',
          todayTempLow: '',
          todayTempLowTime: ''
        },
        summary: '',
        possibility: ''
      },
      tempVar: {
        tempToday: [
          // gets added dynamically by this.getSetHourlyTempInfoToday()
        ],
      },
      highlights: {
        uvIndex: '',
        visibility: '',
        windStatus: {
          windSpeed: '',
          windDirection: '',
          derivedWindDirection: ''
        },
      }
    };
  },
  methods: {
    // Some utility functions
    convertToTitleCase: function(str) {
      str = str.toLowerCase().split(' ');
      for (var i = 0; i < str.length; i++) {
        str[i] = str[i].charAt(0).toUpperCase() + str[i].slice(1);
      }
      return str.join(' ');
    },
    formatPossibility: function(str) {
      str = str.toLowerCase().split('-');
      for (var i = 0; i < str.length; i++) {
        str[i] = str[i].charAt(0).toUpperCase() + str[i].slice(1);
      }
      return str.join(' ');
    },
    milibarToKiloPascal: function(pressureInMilibar) {
      var pressureInKPA = pressureInMilibar * 0.1;
      return Math.round(pressureInKPA);
    },
    mileToKilometer: function(miles) {
      var kilometer = miles * 1.60934;
      return Math.round(kilometer);
    },
    deriveWindDir: function(windDir) {
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
    // Some basic action oriented functions
    makeInputEmpty: function() {
      this.$refs.input.value = '';
    },
    makeTempVarTodayEmpty: function() {
      this.tempVar.tempToday = [];
    },
    detectEnterKeyPress: function() {
      var input = this.$refs.input;
      input.addEventListener('keyup', function(event) {
        event.preventDefault();
        var enterKeyCode = 13;
        if (event.keyCode === enterKeyCode) {
          this.setHitEnterKeyTrue();
        }
      });
    },
    fixWeatherApi: async function() {
      let url = "";
      const today = new Date();
      const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
      url = 'meteo/dia/'+date;
      var weatherApi =
        'meteo/dia/' +
        date;
      this.completeWeatherApi = weatherApi;
    },
    fetchWeatherData: async function() {
      await this.fixWeatherApi();
      var axios = require('axios'); // for handling weather api promise
      var weatherApiResponse = await axios.get(this.completeWeatherApi);
      if (weatherApiResponse.status === 200) {
        this.rawWeatherData = weatherApiResponse.data;
      } else {
        alert('Hmm... Seems like our weather experts are busy!');
      }
    },
    getSetSummary: function() {
      var currentSummary = this.convertToTitleCase(
        this.rawWeatherData.currently.summary
      );
      if (currentSummary.includes(' And')) {
        currentSummary = currentSummary.replace(' And', ',');
      }
      this.currentWeather.summary = currentSummary;
    },
    getSetPossibility: function() {
      var possible = this.formatPossibility(this.rawWeatherData.daily.icon);
      if (possible.includes(' And')) {
        possible = possible.replace(' And', ',');
      }
      this.currentWeather.possibility = possible;
    },
    getSetCurrentTemp: function() {
      var currentTemp = this.rawWeatherData.dadesActuals.metric.temp;
      this.currentWeather.temp = currentTemp;
    },
    getSetTodayTempHighLowWithTime: function() {
      this.currentWeather.todayHighLow.todayTempHigh = this.rawWeatherData.TMax;
      this.currentWeather.todayHighLow.todayTempHighTime = this.rawWeatherData.TMax;
      this.currentWeather.todayHighLow.todayTempLow = this.rawWeatherData.TMin;
      this.currentWeather.todayHighLow.todayTempLowTime = this.rawWeatherData.TMin;
    },
    getTodayDetails: function() {
      return this.rawWeatherData.desglosDia.data[0];
    },
    getHourlyInfoToday: function() {
      return this.rawWeatherData.hourly.data;
    },
    // For Today Highlights
    getSetUVIndex: function() {
      var uvIndex = this.rawWeatherData.currently.uvIndex;
      this.highlights.uvIndex = uvIndex;
    },
    getSetVisibility: function() {
      var visibilityInMiles = this.rawWeatherData.currently.visibility;
      this.highlights.visibility = this.mileToKilometer(visibilityInMiles);
    },
    getSetWindStatus: function() {
      var windSpeedInMiles = this.rawWeatherData.currently.windSpeed;
      this.highlights.windStatus.windSpeed = this.mileToKilometer(
        windSpeedInMiles
      );
      var absoluteWindDir = this.rawWeatherData.currently.windBearing;
      this.highlights.windStatus.windDirection = absoluteWindDir;
      this.highlights.windStatus.derivedWindDirection = this.deriveWindDir(
        absoluteWindDir
      );
    },
    // top level for info section
    organizeCurrentWeatherInfo: function() {
      // data in this.currentWeather
      /*
      Coordinates and location is covered (get & set) in:
      - this.getCoordinates()
      - this.setFormatCoordinates()
      There are lots of async-await involved there.
      So it's better to keep them there.
      */
      this.getSetCurrentTemp();
      this.getSetTodayTempHighLowWithTime();
      this.getSetSummary();
      //this.getSetPossibility();
    },
    organizeTodayHighlights: function() {
      // top level for highlights
      this.getSetUVIndex();
      this.getSetVisibility();
      this.getSetWindStatus();
    },
    // topmost level orchestration
    organizeAllDetails: async function() {
      // top level organization
      await this.fetchWeatherData();
      this.organizeCurrentWeatherInfo();
      this.organizeTodayHighlights();
      this.getSetHourlyTempInfoToday();
    },
  },
  mounted: async function() {
    await this.organizeAllDetails();     
  }
};
</script>