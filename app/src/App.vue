<template>
  <div id="app" class="container flex flex-col h-screen"> 
    <div class="py-4">
      <h1 class="text-3xl">Accordous</h1> 
      
      <div class="bg-gray-200 mb-4 py-4 px-4">
        <a href="#" class="btn btn-primary" @click.stop.prevent="creatingProperty=true">
          <svg class="fill-current text-white inline-block h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 13v10h-6v-6h-6v6h-6v-10h-3l12-12 12 12h-3zm-1-5.907v-5.093h-3v2.093l3 3z"/></svg>
          Cadastrar Imóvel
        </a>
        <a href="#" class="btn btn-primary" @click.stop.prevent="creatingContract=true">
          <svg class="fill-current text-white inline-block h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 12h10v1h-10v-1zm7.816-3h-7.816v1h9.047c-.45-.283-.863-.618-1.231-1zm-7.816-2h6.5c-.134-.32-.237-.656-.319-1h-6.181v1zm13 3.975v2.568c0 4.107-6 2.457-6 2.457s1.518 6-2.638 6h-7.362v-20h9.5c.312-.749.763-1.424 1.316-2h-12.816v24h10.189c3.163 0 9.811-7.223 9.811-9.614v-3.886c-.623.26-1.297.421-2 .475zm4-6.475c0 2.485-2.015 4.5-4.5 4.5s-4.5-2.015-4.5-4.5 2.015-4.5 4.5-4.5 4.5 2.015 4.5 4.5zm-2.156-.882l-.696-.696-2.116 2.169-.992-.941-.696.697 1.688 1.637 2.812-2.866z"/></svg>
          Cadastrar Contrato
        </a>
      </div>
      
      <properties-list 
        v-if="properties.length>0" 
        :properties="properties" 
        @remove="onRemoveProperty"
      />
      
      <div v-else class="alert alert-info text-center">
        Não existem imóveis cadastrados.
      </div>

    </div>

    <modal-property :showing="creatingProperty" @close="creatingProperty=false" @save="onSaveProperty"></modal-property>
    <modal-contract :showing="creatingContract" @close="creatingContract=false" @save="onSaveProperty"></modal-contract>
  </div>
</template>

<script>
import propertyService from '@/services/property.service'
import PropertiesList from '@/components/PropertiesList'
import ModalProperty from '@/components/ModalProperty'
import ModalContract from '@/components/ModalContract'

export default {
  name: 'App',
  data() {
    return {
      properties: [],
      creatingProperty: false,
      creatingContract: false
    } 
  },
  created() {    
    propertyService.list()
      .then(response => {
        this.properties = response.data.data
      })
      .catch(error => {
          alert('Erro ao recuperar a lista de imóveis. Tenta novamente mais tarde.')
          console.log(error)
      })
  },
  methods: {
    onSaveProperty(event) {
      this.properties.push(JSON.parse(JSON.stringify(event)));
    },
    onRemoveProperty(property) {
      propertyService.destroy(property.id)
        .then(response => { 
          let index = this.properties.findIndex( item => item.id === property.id);
          this.properties.splice(index, 1);
          console.log(response);      
        })
        .catch(error => {
          alert('Erro ao apagar o imóvel. Tenta novamente mais tarde.')
          console.log(error)
      })
      
    }
  },  
  components: {
    'properties-list': PropertiesList,
    'modal-property': ModalProperty,
    'modal-contract': ModalContract
  },
}
</script>

<style>

</style>
