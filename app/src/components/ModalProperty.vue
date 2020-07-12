<template>
    <modal :showing="showing" @close="close">
        <div class="modal-title">Cadastrar propriedade</div>
        <div class="modal-body">
            <form class="px-2 pt-6 pb-2 mb-4">
                <div class="mb-4">
                    <label for="" class="label">
                        Email do proprietário
                     </label>
                    <input type="email" class="form-control" placeholder="email@dominio.com" ref="email"/>
                </div>
                
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-3/4 px-3">
                         <label class="label" for="grid-password">
                            Rua
                        </label>
                        <input class="form-control" type="text" placeholder="Rua, Avenida, Travessa, etc.">
                     </div>
                    <div class="w-full md:w-1/4 px-3">
                        <label class="label" for="grid-password">
                            Número
                        </label>
                        <input class="form-control" type="text">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-3/5 px-3">
                        <label class="label" for="grid-password">
                            Complemento
                        </label>
                        <input class="form-control" type="text">
                    </div>

                    <div class="w-full md:w-2/5 px-3">
                        <label class="label" for="grid-password">
                            Bairro
                        </label>
                        <input class="form-control" type="text">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="" class="label">Estado</label>
                        <select-state 
                            empty="Selecione um estado"
                            :options="states"
                            :loading="loadingStates"
                            v-model="state"
                            @input="loadCities" 
                        />
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="" class="label">Cidade</label>
                        <select-city 
                            empty="Selecione uma cidade"
                            :options="cities"
                            :loading="loadingCities"
                            v-model="city"
                        />
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a @click.prevent.stop="save" href="#" class="btn btn-primary">Salvar</a>
            <a @click.prevent.stop="close" href="#" class="btn btn-default">Cancelar</a>
        </div>
    </modal>
</template>

<script>
import Modal from '@/shared/Modal'
import Select from '@/shared/Select'
import stateCityService from '@/services/stateCity.service'

export default {
    data() {
        return {            
            states: [],
            cities: [],
            loadingStates: false,
            loadingCities: false,
            state: -1,
            city: -1
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
            this.state = -1
            this.city = -1
            this.$emit('close')
        },
        save () {
            this.$emit('close', {user:'sdfsdf'})
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
            stateCityService.listCities({state:this.state})
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