<template>
  <div>
    <meteo-actual-component></meteo-actual-component>
    
    <meteo-passat-component></meteo-passat-component>
  </div>
</template>

<script>
import  MeteoActualComponent  from "./components/MeteoActualComponent.vue";
import  MeteoPassatComponent  from "./components/MeteoPassatComponent.vue";
export default {
  comments: {
    'meteo-actual-component':MeteoActualComponent,
    'meteo-passat-component':MeteoPassatComponent,
  },
};
</script>

<style>
  
  .titol{
    background-color: lavender;
  }
    .center {
  display: block;
  margin-left: auto;
  margin-right: auto;
    }
    .temperatura{
        text-align: center;
    }
    .max{
      color: red;
    }
    .min{
      color: blue;
    }
    .actual{
      font-size: 3rem;
    }
    .simbol{
      font-size: 2rem;
    }
</style>