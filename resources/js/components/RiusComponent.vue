<template>
    <div>
        <div class="row titol">
            <span class="col temperatura actual">Rius</span>
        </div>
        <div class="row">
            <span class="col temperatura actual">
                <span class="simbol">Cardener</span><br>
                {{rius.cardener}}m³/s
            </span>
            <span class="col temperatura actual">
                <span class="simbol">Valls</span><br>
                {{rius.valls}}m³/s
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            rius: Object
        },
        mounted() {
            console.log('Rius Component mounted.')
        }
    }
</script>
