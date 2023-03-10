<script setup>
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

defineProps({ 
  links: Array,
  query: Object,
})
</script>

<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap -mb-1">
      <template v-for="(link, index) in links" :key="index">
        <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label"></div>
        <Link v-else 
          class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded bg-gray-200 hover:bg-indigo-400 focus:border-indigo-500 focus:text-indigo-500" 
          :class="{ 'bg-blue-700 text-white': link.active}" 
          :href="link.url" 
          :data="query" 
          v-html="link.label"
        ></Link>
      </template>
    </div>
  </div>
</template>