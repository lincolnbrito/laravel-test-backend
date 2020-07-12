<template>
    <modal :showing="showing" @close="close">
        <ValidationObserver v-slot="{ invalid }">
        <div class="modal-title">Cadastrar Contrato</div>
        <div class="modal-body">
            
            <div v-if="!isValid" class="bg-gray-200 p-4 text-gray-600 rounded text-center">
                Não existem imóveis disponíveis para contratação.
            </div>
            
            <form v-else class="px-2 pt-2 pb-2 mb-4">
                <div class="mb-4">
                    <ValidationProvider name="contract.property_id" rules="required"  v-slot="{ errors }">
                        <label for="" class="label">Imóvel <span class="text-red-700">*</span></label>
                        <select-property 
                            empty="Selecione um imóvel" 
                            :options="properties"
                            :loading="loadingProperties"
                            v-model="contract.property_id"
                        /> 
                        <div v-if="errors.length>0" class="text-red-600 p-1 text-xs font-bold">{{ errors[0] }}</div>
                    </ValidationProvider>                 
                </div>
                 
                <div class="flex flex-wrap -mx-3 mb-2">
                   
                        <div class="w-full md:w-2/5 px-3 mb-2">
                            <ValidationProvider name="contract.hirer_type" rules="required"  v-slot="{ errors }" tag="div">
                                <label class="label">Pessoa <span class="text-red-700">*</span></label>
                                <label class="inline-block mr-2">
                                    <input class="mr-1" v-model="contract.hirer_type" type="radio" name="hirer_type" value="F">
                                    Física
                                </label>
                                <label class="inline-block mr-2">
                                    <input class="mr-1" v-model="contract.hirer_type" type="radio" name="hirer_type" value="J">
                                    Jurídica
                                </label>
                                <div v-if="errors.length>0" class="text-red-600 p-1 text-xs font-bold">{{ errors[0] }}</div>
                             </ValidationProvider> 
                        </div>
                    

                    <div class="w-full md:w-3/5 px-3 mt-2">
                        <ValidationProvider name="contract.hirer_document" rules="required"  v-slot="{ errors }" tag="div">
                            <label class="label" for="grid-password">
                                Documento <span class="text-red-700">*</span>
                            </label>
                            <input v-model="contract.hirer_document" v-mask="documentMask" class="form-control" type="text">
                            <div v-if="errors.length>0" class="text-red-600 p-1 text-xs font-bold">{{ errors[0] }}</div>
                        </ValidationProvider> 
                    </div>
                   
                
                </div>
               
                <div class="mb-4">
                    <ValidationProvider name="contract.hirer_type" rules="required|email"  v-slot="{ errors }" tag="div">
                        <label for="" class="label">Email do Contratante <span class="text-red-700">*</span></label>
                        <input v-model="contract.hirer_email" class="form-control" type="text">
                        <div v-if="errors.length>0" class="text-red-600 p-1 text-xs font-bold">{{ errors[0] }}</div>
                    </ValidationProvider> 
                </div>

                <div class="mb-4">
                    <ValidationProvider name="contract.hirer_name" rules="required"  v-slot="{ errors }" tag="div">
                        <label for="" class="label">Nome do Contratante <span class="text-red-700">*</span></label>
                        <input v-model="contract.hirer_name" class="form-control" type="text">
                        <div v-if="errors.length>0" class="text-red-600 p-1 text-xs font-bold">{{ errors[0] }}</div>
                    </ValidationProvider> 
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button @click.prevent.stop="save" href="#" class="btn btn-primary" :disabled="invalid">Salvar</button>
            <a @click.prevent.stop="close" href="#" class="btn btn-default">Cancelar</a>
        </div>
        </ValidationObserver>
    </modal>
</template>

<script>
import Modal from '@/shared/Modal'
import Select from '@/shared/Select'
import propertyService from '@/services/property.service'
import contractService from '@/services/contract.service'
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
    props: {
        showing: {
            required: true,
            type: Boolean
        },
    },
    
    data() {
        return {            
            properties: [],
            loadingProperties: false,
            contract: {
                property_id: -1,
                hirer_type: "F",
                hirer_document: null,
                hirer_email: null,
                hirer_name: null,
            }
        }
    },
    
    methods: {
        close () {          
            this.$emit('close')
        },
        save (e) {
            contractService.store(this.contract)
                .then((response) => {                    
                    this.$emit('close')
                    this.$emit('save', response.data.data)
                })
                .catch( error => {
                    alert('Erro ao cadastrar o contrato. Tente novamente mais tarde.')
                    console.log(error)
                })
             e.preventDefault();
        },
        loadProperties() {
            this.loadingProperties = true;            
            propertyService.listUnhired()
                .then((response) => {
                    this.loadingProperties = false;
                    this.properties = response.data.data.map(makeOptions)
                })
                .catch( error => {
                    alert('Erro ao carregar a lista de estados. Tente novamente mais tarde.')
                    console.log(error)
                })
        },
    },
    computed: {
        isValid () {
            return this.properties.length > 0;
        },
        documentMask() {
            return this.contract.hirer_type == 'F' ? '###.###.###-##' : '##.###.###/####-##'
        }
    },

    watch: {
        showing (value) {
            this.contract = {
                property_id: -1,
                hirer_type: "F",
                hirer_document: null,
                hirer_email: null,
                hirer_name: null,
            }

            if(value) {
                console.log('SWWWWWW', value)
                this.loadProperties();
            }
        }
    },
    components: {
        'modal': Modal,
        'select-property': Select,
        ValidationProvider,
        ValidationObserver
    },
    
}

function makeOptions(item) {
    return { 
        text: [item.street, item.number, item.complement, item.neighborhood ].join(', '), 
        value:item.id
    }
}
</script>