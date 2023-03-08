<script setup>
import { ref, defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    keyword: String
})

const keyword = ref(props.keyword);
</script>
<template>
  <div>
      <div class="flex">
          <div class="relative w-full">
              <input type="search" v-model="keyword" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border-gray-300 border  focus:ring-blue-500 focus:border-blue-500" placeholder="Search" required>
              <Link 
                href="" 
                :data="{ keyword }"
                as="button"
                class="absolute top-0 right-0 p-3 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 "
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </Link>
          </div>
      </div>
    </div>
</template>