<template>
    <div class="tab-pane fade show active" id="actual" role="tabpanel" aria-labelledby="monthly-tab">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center pb-25">
                    <lavel>Selecciona un periode o data concreta: </lavel>
                    <select v-model="selectedany" v-on:change="obtenirSelectAny">
                        <option value="">Any</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                    </select>
                    <select v-if="selectedany" v-model="selectedmes" v-on:change="obtenirSelectMes">
                        <option value="">Mes</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <select v-if="selectedmes" v-model="selecteddia" v-on:change="obtenirSelectMes">
                        <option value="">Dia</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
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
            selectedany: '',
            selectedmes: '',
            selecteddia: '',
        }
    },
    props: ['highlights', 'tempVar'],
    components: {
    },

    methods: {
        obtenirSelectAny(){
            this.$emit('selectedany', this.selectedany);
        },
        obtenirSelectMes(){
            this.$emit('selectedmes', this.selectedmes);
        },obtenirSelectDia(){
            this.$emit('selecteddia', this.selecteddia);
        }
    },
}
</script>