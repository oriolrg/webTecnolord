<template>
    <div>
        <div class="row titol">
            <span class="col temperatura actual">Vent</span>
        </div>
        <div class="row">
            <div class="col">
                <span class="col temperatura actual">{{vent.wind_speed.value}} <span class="simbol">{{vent.wind_speed.unit}}</span> </span>
            </div>
            <div class="col">
                <span class="col temperatura actual">{{vent.wind_direction.value}} <span class="simbol">{{vent.wind_direction.unit}} {{ this.dirVent }}</span></span>
            </div>
            <div class="col">
                <span class="col temperatura actual">{{vent.wind_gust.value}} <span class="simbol">{{vent.wind_gust.unit}} </span></span>
            </div>
        </div>
        <div class="row">
            <span class="col temperatura max" v-if="ventMax"><i>▲</i> {{ventMax.max.wind_speed}} {{vent.wind_speed.unit}} </span>
            <span class="col"></span>
            <span class="col temperatura max" v-if="rafegaMax"><i>▲</i> {{rafegaMax.max.wind_gust}} {{vent.wind_speed.unit}} </span>
        </div>
        <div class="row">
            <span class="col temperatura " v-if="ventMax">Avui a les {{
                new Date(ventMax.max.hora).getHours() + 
                ":" + 
                new Date(ventMax.max.hora).getMinutes()}} 
            </span>
            <span class="col"></span>
            <span class="col temperatura " v-if="rafegaMax">Avui a les 
                {{new Date(rafegaMax.max.hora).getHours() + 
                ":" + 
                new Date(rafegaMax.max.hora).getMinutes()}}
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                dirVent: null
            }
        },
        props: {
            vent: Object,
            rafegaMax: Object,
            ventMax: Object,
        },
        methods:{
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
        },
        mounted() {
            this.dirVent = this.calculDireccioVent(this.vent?.wind_direction.value)
            console.log('Vent Component mounted.')
        }
    }
</script>
