<script setup>
import { defineProps } from 'vue';

defineProps({
  article: Object
})
</script>
<template>
  <div class="block bg-white rounded-lg p-1 shadow-lg">
    <a :href="article.url" target="_blank" rel="noopener noreferrer" >
      <img class="h-48 hover:cursor-pointer rounded w-full object-cover object-center mb-6 border hover:opacity-80" :src="article.thumbnail_url" alt="content">
    </a>
    <div class="px-3 h-24 overflow-hidden">
      <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ article.title }}</h2>
      <p class="leading-relaxed text-base">{{ article.description }}</p>  
    </div>
    <slot /> 
  </div>
  
</template>