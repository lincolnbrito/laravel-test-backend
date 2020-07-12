<template>
    <modal :showing="showing" @close="close">
        <ValidationObserver v-slot="{ invalid }">
        <div class="modal-title">Cadastrar Imóvel</div>
        <div class="modal-body">
            <form class="px-2 pt-2 pb-2 mb-4">
                <div class="mb-4">
                    <ValidationProvider name="property.email" rules="required|email"  v-slot="{ errors }">
                        <label for="" class="label">
                            Email do proprietário <span class="text-red-700">*</span>
                        </label>
                        <input v-model="property.email" type="email" class="form-control" placeholder="email@dominio.com" ref="email"/>
                        <div v-if="errors.length>0" class="text-red-600 p-1 text-xs font-bold">{{ errors[0] }}</div>
                    </ValidationProvider>
                </div>
                
                <ValidationProvider name="property.street" rules="required"  v-slot="{ errors }">
                    <div class="flex flex-wrap -mx-3 mb-2">
                        <div class="w-full md:w-3/4 px-3">
                            <label class="label" for="">
                                Rua <span class="text-red-700">*</span>
                            </label>
                            <input v-model="property.street" class="form-control" type="text" placeholder="Rua, Avenida, Travessa, etc.">
                        </div>
                        <div class="w-full md:w-1/4 px-3">
                            <label class="label" for="">
                                Número
                            </label>
                            <input v-model="property.number" class="form-control" type="text">
                        </div>
                        <div v-if="errors.length>0" class="text-red-600 p-1 text-xs font-bold px-3">{{ errors[0] }}</div>
                    </div>
                </ValidationProvider>

                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-3/5 px-3">
                        <label class="label" for="">
                            Complemento
                        </label>
                        <input v-model="property.complement" class="form-control" type="text">
                    </div>
                    
                    <div class="w-full md:w-2/5 px-3">
                        <ValidationProvider name="property.street" rules="required"  v-slot="{ errors }" tag="div">
                            <label class="label" for="">
                                Bairro <span class="text-red-700">*</span>
                            </label>
                            <input v-model="property.neighborhood" class="form-control" type="text">
                            <div v-if="errors.length>0" class="text-red-600 p-1 text-xs font-bold">{{ errors[0] }}</div>
                        </ValidationProvider>
                    </div>                    
                </div>

                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="" class="label">Estado <span class="text-red-700">*</span></label>
                        <select-state 
                            empty="Selecione um estado"
                            :options="states"
                            :loading="loadingStates"
                            v-model="property.state_id"
                            @input="loadCities"    
                        />
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="" class="label">Cidade <span class="text-red-700">*</span></label>
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
            <a @click.prevent.stop="save" href="#" class="btn btn-primary" :disabled="invalid">Salvar</a>
            <a @click.prevent.stop="close" href="#" class="btn btn-default">Cancelar</a>
        </div>
        </ValidationObserver>
    </modal>
</template>

<script>
import Modal from '@/shared/Modal'
import Select from '@/shared/Select'
import stateCityService from '@/services/stateCity.service'
import propertyService from '@/services/property.service'
import { ValidationProvider,ValidationObserver } from 'vee-validate';
import { extend } from 'vee-validate';
import { required, email, is_not } from 'vee-validate/dist/rules';

extend('required', {
  ...required,
  message: 'Campo obrigatório'
});

extend('email', {
  ...email,
  message: 'Email inválido'
});

extend('is_not', {
  ...is_not,
  message: 'Inválido'
});

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
                .then((response) => {
                    this.$emit('close')
                    this.$emit('save', response.data.data)
                })
                .catch( error => {
                    alert('Erro ao cadastrar o imóvel. Tente novamente mais tarde.')
                    console.log(error)
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
                .catch( error => {
                    alert('Erro ao carregar a lista de estados. Tente novamente mais tarde.')
                    console.log(error)
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
                .catch( error => {
                    alert('Erro ao carregar a lista de cidades. Tente novamente mais tarde.')
                    console.log(error)
                })
        },
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
    },

    components: {
        'modal': Modal,
        'select-state': Select,
        'select-city': Select,
        ValidationProvider,
        ValidationObserver
    },
}
function makeOptions(item) {
    return {text:item.name, value:item.id}
}
</script>