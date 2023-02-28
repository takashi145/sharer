<script setup>
import { defineProps } from 'vue';
import Like from '@/Components/Like.vue';
import { Link, router } from '@inertiajs/vue3';
import TimeDiff from '@/utils/time-diff';

const props = defineProps({
  article: Object
})

const deleteArticle = () => {
  router.delete(`/articles/${props.article.id}`, {
    onBefore: () => confirm('本当に削除してもよろしいですか？')
  });
}
</script>
<template>
  <div class="block bg-slate-200 rounded-lg p-1 shadow-lg">
    <details class=" flex items-center justify-between">
        <summary class="m-2 hover:cursor-pointer">{{ article.title2 }}</summary>
        <div class="m-3 space-y-1">
          <div class="text-sm">
            共有者：<Link :href="route('user.index', article.user.id)" class=" text-gray-600 hover:text-gray-800 underline hover:cursor-pointer">{{ article.user.name }}</Link>
          </div>
          <div class="text-xs">
            投稿日：{{ TimeDiff(article.updated_at) }}
          </div>
          <div v-if="$page.props.auth.user.id === article.user.id" class=" space-x-3">
            <button
              @click="deleteArticle()"
              class="mr-3 text-sm text-red-400 hover:text-red-600 hover:underline"
            >
              削除
            </button>
          </div>
        </div>
    </details>
    <div class="bg-gray-100 p-1 rounded hover:ring-2 ">
      <a :href="article.url" target="_blank" rel="noopener noreferrer" >
        <img class="h-60 sm:h-48 hover:cursor-pointer rounded w-full object-cover object-center mb-6 border hover:opacity-75" :src="article.thumbnail_url" alt="content">
      </a>
      <div class="px-2 h-24 overflow-y-scroll">
        <h2 class="text-sm md:text-lg text-gray-900 font-medium title-font mb-4">{{ article.title }}</h2>
        <p class="text-xs md:text-sm leading-relaxed">{{ article.description }}</p>  
      </div>
    </div>
    
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
      <Like 
        :article_id="article.id" 
        :is_liked="article.is_liked"
        class="mx-3"
      />  
    </div>
  </div>
  
</template>