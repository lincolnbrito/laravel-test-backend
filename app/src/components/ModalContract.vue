<template>
    <modal :showing="showing" @close="close">
        <div class="modal-title">Cadastrar Contrato</div>
        <div class="modal-body">
            
        </div>
        <div class="modal-footer">
            <a @click.prevent.stop="save" href="#" class="btn btn-primary">Salvar</a>
            <a @click.prevent.stop="close" href="#" class="btn btn-default">Cancelar</a>
        </div>
    </modal>
</template>

<script>
import Modal from '@/shared/Modal'

export default {
    props: {
        showing: {
            required: true,
            type: Boolean
        },
    },
    
    data() {
        return {}
    },
    
    methods: {
        close () {          
            this.$emit('close')
        }
    },
    
    components: {
        'modal': Modal,       
    },
}

</script>