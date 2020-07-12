<template>
    <modal :showing="showing" @close="close">
        <div class="modal-title">Cadastrar Contrato</div>
        <div class="modal-body">
            <form class="px-2 pt-2 pb-2 mb-4">
                <div class="mb-4">
                    <label for="" class="label">Imóvel</label>
                    <select-property 
                        empty="Selecione um imóvel" 
                        :options="properties"
                        :loading="loadingProperties"
                        v-model="contract.property_id"
                    />
                </div>

                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-2/5 px-3 mb-2">
                        <label class="label">Pessoa</label>
                        <label class="inline-block mr-2">
                            <input class="mr-1" v-model="contract.hirer_type" type="radio" name="hirer_type" value="F">
                            Física
                        </label>
                         <label class="inline-block mr-2">
                            <input class="mr-1" v-model="contract.hirer_type" type="radio" name="hirer_type" value="J">
                            Jurídica
                        </label>
                    </div>

                    <div class="w-full md:w-3/5 px-3 mt-2">
                        <label class="label" for="grid-password">
                            Documento
                        </label>
                        <input v-model="contract.hirer_document" class="form-control" type="text">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="" class="label">Email do Contratante</label>
                    <input v-model="contract.hirer_email" class="form-control" type="text">
                </div>

                <div class="mb-4">
                    <label for="" class="label">Nome do Contratante</label>
                    <input v-model="contract.hirer_name" class="form-control" type="text">
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
import propertyService from '@/services/property.service'
import contractService from '@/services/contract.service'

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
            propertyService.list()
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
    
    components: {
        'modal': Modal,
        'select-property': Select,
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
    }
}

function makeOptions(item) {
    return { 
        text: [item.street, item.number, item.complement, item.neighborhood ].join(', '), 
        value:item.id
    }
}
</script>