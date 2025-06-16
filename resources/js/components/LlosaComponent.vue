<template>
    <div>
        <div class="row titol">
            <span class="col temperatura actual">Llosa del Caball</span>
        </div>
        <div class="row">
            <span class="col temperatura actual">
                <span class="simbol">Sortida Llosa</span><br>
                {{llosa.llosa}}m³/s
            </span>
            <span class="col temperatura actual">
                <span class="simbol">Capacitat Llosa</span><br>
                {{llosa.capacitatllosa}}%
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            llosa: Object
        },
        mounted() {
            console.log('Llosa Component mounted.')
        }
    }
</script>
