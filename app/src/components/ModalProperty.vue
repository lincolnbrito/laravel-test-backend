<template>
    <modal :showing="showing" @close="close">
        <div class="modal-title">Cadastrar Imóvel</div>
        <div class="modal-body">
            <form class="px-2 pt-2 pb-2 mb-4">
                <div class="mb-4">
                    <label for="" class="label">
                        Email do proprietário
                     </label>
                    <input v-model="property.email" type="email" class="form-control" placeholder="email@dominio.com" ref="email"/>
                </div>
                
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-3/4 px-3">
                         <label class="label" for="grid-password">
                            Rua
                        </label>
                        <input v-model="property.street" class="form-control" type="text" placeholder="Rua, Avenida, Travessa, etc.">
                     </div>
                    <div class="w-full md:w-1/4 px-3">
                        <label class="label" for="grid-password">
                            Número
                        </label>
                        <input v-model="property.number" class="form-control" type="text">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-3/5 px-3">
                        <label class="label" for="grid-password">
                            Complemento
                        </label>
                        <input v-model="property.complement" class="form-control" type="text">
                    </div>

                    <div class="w-full md:w-2/5 px-3">
                        <label class="label" for="grid-password">
                            Bairro
                        </label>
                        <input v-model="property.neighborhood" class="form-control" type="text">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="" class="label">Estado</label>
                        <select-state 
                            empty="Selecione um estado"
                            :options="states"
                            :loading="loadingStates"
                            v-model="property.state_id"
                            @input="loadCities" 
                        />
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="" class="label">Cidade</label>
                        <select-city 
                            empty="Selecione uma cidade"
                            :options="cities"
                            :loading="loadingCities"
                            v-model="property.city_id"
                        />
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a @click.prevent.stop="save" class="btn btn-primary">Salvar</a>
            <a @click.prevent.stop="close" href="#" class="btn btn-default">Cancelar</a>
        </div>
    </modal>
</template>

<script>
import Modal from '@/shared/Modal'
import Select from '@/shared/Select'
import stateCityService from '@/services/stateCity.service'
import propertyService from '@/services/property.service'

export default {
    data() {
        return {            
            states: [],
            cities: [],
            loadingStates: false,
            loadingCities: false,
            property: {
                email: null,
                street: null,
                number: null,
                complement: null,
                neighbohood: null,
                state_id: -1,
                city_id: -1,
            }
        }
    },
    props: {
        showing: {
            required: true,
            type: Boolean
        },
    },
    methods: {
        close () {          
            this.$emit('close')
        },
        save (e) {
            propertyService.store(this.property)
                .then(() => {
                    this.close()
                })
                .catch( error => {
                    console.log('ERRRP', error)
                })
             e.preventDefault();
        },
        loadStates() {
            this.loadingStates = true;            
            stateCityService.listStates()
                .then((response) => {
                    this.loadingStates = false;
                    this.states = response.data.data.map(makeOptions)
                })
        },
        loadCities() {
           this.loadingCities = true;
           this.property.city_id = -1;
            stateCityService.listCities({state:this.property.state_id})
                .then((response) => {
                    this.loadingCities = false;
                    this.cities = response.data.data.map(makeOptions)
                })
        }
    },
    components: {
        'modal': Modal,
        'select-state': Select,
        'select-city': Select,
    },
    watch: {
        showing (value) {
            this.property = {
                email: null,
                street: null,
                number: null,
                complement: null,
                neighbohood: null,
                state_id: -1,
                city_id: -1,
            }

            if(value) {
                this.$nextTick(() => {
                    this.$refs["email"].focus();
                });

                this.loadStates();
            }
        }
    }
}
function makeOptions(item) {
    return {text:item.name, value:item.id}
}
</script>