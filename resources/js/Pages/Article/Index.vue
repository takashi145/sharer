<script setup>
import Pagination from '@/Components/Pagination.vue';
import SearchInput from '@/Components/SearchInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import LinkCard from '@/Components/LinkCard.vue';

defineProps({
  'category': Object,
  'articles': Array,
  'tag_name': String,
  'keyword': String
})

</script>

<template>
  <Head title="ArticlePage" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="text-lg text-gray-800 leading-tight">
          カテゴリー: 
          <span class="font-semibold underline">{{ category.name }}</span>
        </h2>
        <div class="w-2/3 lg:w-1/3 flex items-center">
          <Link v-if="keyword" href="" :data="{'keyword': null}" class="text-sm underline text-blue-500 hover:text-blue-600">リセット</Link>
          <SearchInput :keyword="keyword" class="ml-3 mr-8 w-2/3" />
        </div>  
      </div>
    </template>

    <div class="mt-8 pb-24">
      <div v-if="tag_name" class="flex mx-8 mb-4 items-center">
        <h2 class="underline text-xl flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
          </svg>
          {{ tag_name }}
        </h2>
        <Link :href="route('article.index', {'category': category.id })">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-2 text-gray-500 hover:text-gray-700 hover:scale-105">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </Link>
      </div>

      <div class="max-w-7xl mx-auto sm:px-4">
        <Link 
          :href="route('category.index')"
          class="text-blue-400 hover:text-blue-500 underline mx-3"
        >←ホームへ戻る</Link>
        
        <div v-if="articles.data.length >= 1">
          <ul class="flex flex-wrap">
            <li v-for="article in articles.data" :key="article.id" class="w-1/2 md:w-1/3 lg:w-1/5 p-3">
              <LinkCard :article="article" />
            </li>
          </ul>
          <div class="flex justify-center mt-8">
            <Pagination 
              :links="articles.meta.links" 
              :query="{'keyword': keyword}" 
            />
          </div>
        </div>
        <div v-else class="text-center text-xl mt-24 text-gray-700">
          記事がありません。
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
