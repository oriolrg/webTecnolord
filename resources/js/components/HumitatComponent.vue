<template>
    <div>
        <div class="row titol">
            <span class="col temperatura actual">Humitat</span>
        </div>
        <div class="row">
            <span class="col temperatura actual">{{humitat.humidity.value}} <span class="simbol">{{humitat.humidity.unit}}</span> </span>
        </div>

        <div class="row">
            <span class="col temperatura max" v-if="humitatMax"><i>▲</i> {{humitatMax.humitat}} {{humitat.humidity.unit}}</span>
            <span class="col temperatura min" v-if="humitatMin"><i>▼</i> {{humitatMin.humitat}} {{humitat.humidity.unit}}</span>
        </div>
        
        <div class="row">
            <span class="col temperatura">Rosada<br> {{humitat.dew_point.value}} {{humitat.dew_point.unit}} </span>
            <span class="col temperatura" >Sensació<br> {{humitat.feels_like.value}} {{humitat.feels_like.unit}} </span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            humitat: Object,
            humitatMax: Object,
            humitatMin: Object,
        },
        mounted() {
            console.log('Humitat Component mounted.')
        }
    }
</script>
