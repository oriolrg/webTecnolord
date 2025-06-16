<template>
    <div>
        <div class="row titol">
            <span class="col temperatura actual">Pluja</span>
        </div>
        <div class="row">
            <div class="col">
                <span class="col temperatura actual"><span class="simbol">Intensitat</span> <br>{{pluja.rain_rate.value}} <span class="simbol">mm/hr</span></span> <br>

                <span class="col temperatura actual"><span class="simbol">Acomulat</span> <br>{{pluja.daily.value}} <span class="simbol">mm</span></span> 
            </div>
            <div class="col">
                
                <div class="col temperatura"><span class="simbol">Episodi: {{pluja.event.value}} {{pluja.event.unit}}</span></div> 

                <div class="col temperatura"><span class="simbol">Hora: {{pluja.hourly.value}} {{pluja.hourly.unit}}</span></div> 

                <div class="col temperatura"><span class="simbol">Setmana: {{pluja.weekly.value}} {{pluja.weekly.unit}}</span></div> 

                <div class="col temperatura"><span class="simbol">Mes: {{pluja.monthly.value}} {{pluja.monthly.unit}}</span></div> 
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            pluja: Object
        },
        mounted() {
            console.log('Pluja Component mounted.')
        }
    }
</script>
<style>
.simbol{
    font-size: 2rem !important;
}
</style>