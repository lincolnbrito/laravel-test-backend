<template>
    <div class="relative">
        <select v-model="model" :disabled="loading" class="appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
            <option :value="-1" v-if="loading" disabled>Carregando...</option>
            <option :value="-1" v-else disabled>{{empty}}</option>
            <option 
                v-for="option in options" 
                :value="option.value" 
                :key="option.value"            
            >
                {{option.text}}
            </option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        value:{
            required: false
        },
        loading: {
            type: Boolean
        },
        options: {
            type: Array
        },
        empty: {
            type: String
        }
    },
    computed:{
        model:{
            get(){
                return this.value
            },
            set(val){
                this.$emit('input', val)
            }
        }
    }, 
}
</script>