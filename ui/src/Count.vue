<script setup>
import { ref } from 'vue';
const msg = 'test'
const count = ref(0);
const str ='<span style="color: red">This should be red.</span>'
const objectOfAttrs = {
  id: 'container',
  class: 'wrapper',
  style: 'background-color:green'
}
</script>

<template>
  <button @click="count++">
    <div >Clics : {{ count }}</div>
  </button>
  <p>Using text interpolation: {{ str }}</p>
<p>Using v-html directive: <span v-html="str"></span></p>
</template>

<style>
button {
  font-size: 1.2em;
  padding: 0.5em 1em;
  cursor: pointer;
}
</style>
