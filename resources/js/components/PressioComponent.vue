<template>
    <div>
        <div class="row titol">
            <span class="col temperatura actual">Pressio</span>
        </div>
        <div class="row">
            <span class="col temperatura actual">
                <span class="simbol">Relativa<br>
                {{pressio.relative.value}} {{pressio.relative.unit}} </span>
            </span>
            <span class="col temperatura actual">
                <span class="simbol">Absoluta<br>
                {{pressio.absolute.value}} {{pressio.absolute.unit}} </span>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            pressio: Object
        },
        mounted() {
            console.log('Pressio Component mounted.')
        }
    }
</script>
