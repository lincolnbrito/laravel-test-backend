<template>
  <div id="app" class="container flex flex-col h-screen"> 
    <div class="py-4">
      <h1 class="text-2xl">Accordous</h1> 
      
      <properties-list v-if="properties.length>0" :properties="properties"></properties-list>
      <div v-else class="text-center">
        <p>Sem propriedades cadastradas ainda.</p>
        <div><a @click.stop.prevent="creatingProperty=true">Cadastrar</a></div>
      </div>

    </div>

    <modal-property :showing="creatingProperty" @close="creatingProperty=false">
      <p>Ola</p>
    </modal-property>
  </div>
</template>

<script>
import propertyService from '@/services/property.service'
import PropertiesList from '@/components/PropertiesList'
import ModalProperty from '@/components/ModalProperty'

export default {
  name: 'App',
  data() {
    return {
      properties: [],
      creatingProperty: false
    } 
  },
  created() {    
    propertyService.list().then(response => {
        this.properties = response.data.data
      })
      .catch(error => {
          console.log(error)
      })
  },
  components: {
    'properties-list': PropertiesList,
    'modal-property': ModalProperty,
    //'modal-contract': Modal
  },
}
</script>

<style>

</style>
