<template>
    <div class="tab-pane fade show active" id="actual" role="tabpanel" aria-labelledby="monthly-tab">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center pb-25">
                    <lavel>Selecciona un periode: </lavel>
                    <select v-model="selected" v-on:change="obtenirSelect">
                        <option value="actuals">Actuals</option>
                        <option value="mensuals">Mensuals</option>
                        <option value="anuals">Anuals</option>
                    </select>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
export default {
    components: {
        'date-picker':Datepicker
    },
    data () {
        return {
            selected: '',
        }
    },
    components: {
    },

    methods: {
        obtenirSelect(){
            this.$emit('selecting', this.selected);
        },
    },
}
</script>