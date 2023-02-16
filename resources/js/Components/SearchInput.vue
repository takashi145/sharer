<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const keyword = ref('');
</script>
<template>
  <div>
      <div class="flex">
          <div class="relative w-full">
              <input type="search" v-model="keyword" class="block p-3 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border-gray-300 border  focus:ring-blue-500 focus:border-blue-500" placeholder="Search" required>
              <Link :href="route('articles.index', {keyword: keyword})" class="absolute top-0 right-0 p-3 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 ">
                  <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                  <span class="sr-only">Search</span>
              </Link>
          </div>
      </div>
    </div>
</template>