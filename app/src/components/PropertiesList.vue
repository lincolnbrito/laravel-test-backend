<template>
    <div>
        <table class="table striped mb-4 text-md">
            <thead>
                <tr>
                    <th><a href="#" @click.prevent.stop="sortBy('email')">Email do proprietário</a></th>
                    <th><a href="#" @click.prevent.stop="sortBy('street')">Endereço</a></th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="property in filtered" :key="property.id">
                    <td>{{property.email}}</td>
                    <td>{{property.street}}, {{property.number}}, {{property.city.name}}, {{property.state.name}}</td>
                    <td width="10%">
                        <span class="badge badge-default">????</span>
                    </td>
                    <td width="5%">
                        <a title="Apagar" href="#" @click="remove(property)">
                            <svg class="fill-current text-red-500 inline-block h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z"/></svg>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
       
    </div>
</template>

<script>
export default {
    props: {
        properties: {
            type: Array
        }
    },
    data() {
        return {
            sort: 'email',
            desc: false
        }
    },
    methods: {
        sortBy(sort) {
            this.sort = sort
            this.desc = !this.desc           
        },
        remove(property) {
            if(!confirm('Deseja realmente apagar este imóvel?'))
                return;

            this.$emit('remove', property)
        }
    },
    computed: {
        filtered() {
            return this.properties.slice().sort((a, b) => {
                if(this.desc) 
                    return (a[this.sort] > b[this.sort]) ? -1 : 1;
                else
                    return (a[this.sort] > b[this.sort]) ? 1 : -1;                
            })
        }
    }
}
</script>