<template>
  <transition name="fade" :duration="{ enter: 300, leave: 400 }">
    <div v-if="showing" class="modal">
      <div class="static w-1/2 max-w-3xl bg-white shadow-lg rounded">
        <button @click.prevent="close" class="close">
          ×
        </button>
        <div class="p-2">
          <slot/>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    showing: {
      required: true,
      type: Boolean
    }
  },
  methods: {
    close () {
      this.$emit('close')
    }
  },
  watch: {
    showing (value) {
      if (value) {
        //return document.querySelector('body').classList.add('overflow-hidden')
      }

      //document.querySelector('body').classList.remove('overflow-hidden')
    }
  }
}
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
