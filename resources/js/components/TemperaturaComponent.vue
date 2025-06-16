<template>
    <div>
        <div class="row titol">
            <span class="col temperatura actual">Temperatura</span>
        </div>
        <div class="row">
            <span class="col temperatura actual">{{temperatura.value}} <span class="simbol">{{temperatura.unit}}</span></span>
        </div>
        <div class="row">
            <span class="col temperatura max" v-if="temperaturaMax"><i>▲</i> {{temperaturaMax.max.temperatura}} {{temperatura.unit}}</span>
            <span class="col temperatura min" v-if="temperaturaMin"><i>▼</i> {{temperaturaMin.min.temperatura}} {{temperatura.unit}}</span>
        </div>
        <div class="row">
            <span class="col temperatura " v-if="temperaturaMax">Avui a les <br>{{
                new Date(temperaturaMax.max.hora).getHours() + 
                ":" + 
                new Date(temperaturaMax.max.hora).getMinutes()}} 
            </span>
            <span class="col temperatura " v-if="temperaturaMax">Avui a les <br>
                {{new Date(temperaturaMax.min.hora).getHours() + 
                ":" + 
                new Date(temperaturaMax.min.hora).getMinutes()}}
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        
        props: {
            temperatura: Object,
            temperaturaMax: Object,
            temperaturaMin: Object,
        },
        mounted() {
            console.log('Temperatura Component mounted.')
        }
    }
</script>