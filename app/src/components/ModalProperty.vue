<template>
    <modal :showing="showing" @close="close">
        <div class="modal-title">Cadastrar propriedade</div>
        <div class="modal-body">
            Formulário
        </div>
        <div class="modal-footer">
            <a @click.prevent.stop="save" href="#" class="btn btn-primary">Salvar</a>
            <a @click.prevent.stop="close" href="#" class="btn btn-default">Cancelar</a>
        </div>
    </modal>
</template>

<script>
import Modal from '@/shared/Modal';

export default {
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
        save () {
            this.$emit('close', {user:'sdfsdf'})
        }
    },
    components: {
        'modal': Modal
    }
}
</script>