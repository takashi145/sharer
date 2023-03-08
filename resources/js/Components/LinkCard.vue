<script setup>
import { defineProps } from 'vue';
import Like from '@/Components/Like.vue';
import { Link, router } from '@inertiajs/vue3';
import {TimeDiff, NewDate} from '@/utils/time-diff';

const props = defineProps({
  article: Object
})

const now = new Date();

const deleteArticle = () => {
  router.delete(`/articles/${props.article.id}`, {
    onBefore: () => confirm('本当に削除してもよろしいですか？')
  });
}
</script>
<template>
  <div class="p-1 shadow-lg bg-white">
    <div class="flex justify-between">
      <div>
        <span class="text-sm">共有者: </span>
        <Link :href="route('user.index', article.user.id)" class=" text-gray-600 hover:text-gray-800 underline hover:cursor-pointer">{{ article.user.name }}</Link>  
      </div>
      <div v-if="NewDate(article.updated_at)" class="p-1 text-green-500 font-semibold">
        New
      </div>
    </div>
    
    
    <a :href="article.url" target="_blank" rel="noopener noreferrer" >
      <img class="h-36 w-full hover:cursor-pointer   object-cover object-center mb-6 border hover:opacity-75" :src="article.thumbnail_url" alt="content">
    </a>
    <div class="px-2 h-10 overflow-y-auto">
      <h2 class="text-sm text-gray-900 font-medium title-font mb-4">{{ article.title2 }}</h2>
    </div>
    <p class="text-xs text-end">{{ TimeDiff(article.updated_at) }}</p>
    <div class="flex justify-between mt-3">
      <ul class="flex flex-wrap">
        <li v-for="tag in article.tags" :key="tag.id" class="flex items-center p-1 bg-gray-300 rounded text-sm mx-1 mb-2">
          <Link :href="`/articles?tag=${tag.name}`" class="flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
            </svg>
            {{ tag.name }}
          </Link>
        </li>
      </ul>
      <!-- <Like 
        :article_id="article.id" 
        :is_liked="article.is_liked"
        class="m-1"
      />   -->
    </div>
  </div>
  
</template>