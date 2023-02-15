<script setup>
import { defineProps } from 'vue';
import Like from '@/Components/Like.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  article: Object
})
</script>
<template>
  <div class="block bg-slate-200 rounded-lg p-1 shadow-lg">
    <p class="m-2">共有者：<Link :href="route('user.index', article.user.id)" class="text-lg text-gray-600 hover:text-gray-800 underline hover:cursor-pointer">{{ article.user.name }}</Link></p>
    <div class="bg-gray-100 p-1 rounded hover:ring-2 hover:-rotate-3 hover:scale-110">
      <a :href="article.url" class="" target="_blank" rel="noopener noreferrer" >
        <img class="h-80 md:h-48 hover:cursor-pointer rounded w-full object-cover object-center mb-6 border hover:opacity-80" :src="article.thumbnail_url" alt="content">
      </a>
      <div class="px-3 h-24 overflow-hidden">
        <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ article.title }}</h2>
        <p class="leading-relaxed text-base">{{ article.description }}</p>  
      </div>
    </div>
    
    <div class="flex justify-between my-3">
      <ul class="flex flex-wrap">
        <li v-for="tag in article.tags" :key="tag.id" class="flex items-center p-1 bg-gray-300 rounded text-sm mx-2 mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
          </svg>
          {{ tag.name }}
        </li>
      </ul>
      <Like 
        :article_id="article.id" 
        :is_liked="article.is_liked"
        class="mx-3"
      />
    </div>
    
    <slot /> 
  </div>
  
</template>