<template>
  <div id="app" class="container flex flex-col h-screen"> 
    <div class="py-4">
      <h1 class="text-2xl">Accordous</h1> 
      <properties-list :properties="properties"></properties-list>     
    </div>
  </div>
</template>

<script>
import propertyService from './services/property.service'
import PropertiesList from './components/PropertiesList'

export default {
  name: 'App',
  data() {
    return {
      properties: []
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
    'properties-list': PropertiesList
  },
}
</script>

<style>

</style>
