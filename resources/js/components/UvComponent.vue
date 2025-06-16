<template>
    <div>
        <div class="row titol">
            <span class="col temperatura actual">Uv</span>
        </div>
        <div class="row">
            <span class="col temperatura actual"><span class="simbol">{{uv.uvi.value}} {{ this.uvi }}</span></span>
            <span class="col temperatura actual"><span class="simbol">{{uv.solar.value}}  W/m²</span></span>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                uvi: null
            }
        },
        props: {
            uv: Object
        },
        methods: {
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
        },
        mounted() {
            this.uvi = this.calculIndexUV(this.uv?.uvi.value)
            console.log('Uv Component mounted.')
        }
    }
</script>
