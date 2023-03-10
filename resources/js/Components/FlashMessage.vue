<script setup>
import {ref, defineProps } from 'vue';

const props = defineProps({
  status: String,
  message: String
});

const show = ref(!!props.message)

setTimeout(() => {
    show.value = null;
}, 3000);

</script>
<template>
  <div 
      v-if="show" 
      class="fixed top-8 w-full"
  >
      <div 
          @click="message = null"
          :class='[
              status === "success" 
              ? "bg-green-400" 
              : "bg-red-400"
          ]'
          class="text-white w-2/3 rounded mx-auto text-center p-2 hover:cursor-pointer hover:scale-105"
      >
          {{ message }}
      </div>
  </div>
</template>