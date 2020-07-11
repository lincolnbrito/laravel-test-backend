<template>
    <div>
        <table v-if="properties.length>0" class="table striped mb-4 text-md">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Endereço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="property in properties" :key="property.id">
                    <td>{{property.email}}</td>
                    <td>{{property.street}}, {{property.number}}, {{property.city.name}}, {{property.state.name}}</td>
                    <td width="10%">
                        <span class="badge badge-success">contratado</span>
                    </td>
                    <td width="5%">
                        <a>Remover</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-else>
            <div class="text-center">Sem propriedades cadastradas</div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        properties: {
            //required: true,
            type: Array
        }
    }    
}
</script>