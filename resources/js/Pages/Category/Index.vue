<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps, ref } from 'vue';
import LinkCard from '@/Components/LinkCard.vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import SearchInput from '@/Components/SearchInput.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps({
  categories: Array,
})

const show = ref(false);


</script>
<template>
  <Head title="ArticlePage" />

  <AuthenticatedLayout>
    <div class="mt-8 pb-24">
      <div class="max-w-7xl mx-auto sm:px-4">
        <div v-if="categories.data.length >= 1">
          <div v-for="category in categories.data" :key="category.id" class="mx-4 mb-8 pb-8 border-b">
            <h3 class="text-xl ml-2">
              {{ category.name }}
              <Link 
                :href="route('article.index', {'category': category.id})" 
                class="mx-2 text-sm text-blue-400 hover:text-blue-600 underline"
              >すべて見る→</Link>
            </h3>
            <div class="overflow-x-auto pb-3 mx-6">
              <ul v-if="category.articles.length >= 1" class="flex items-center min-w-max mt-4 mx-3">
                <li v-for="article in category.articles" :key="article.id" class="w-64 p-3">
                  <LinkCard :article="article" />
                </li>
                <li>
                  <Link :href="route('article.index', {'category': category.id})" class=" text-blue-500 font-extrabold">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 hover:scale-110">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>
                  </Link>
                </li>
              </ul>
              <div v-else class="mt-8 ml-24 text-gray-700">
                記事がありません
              </div>
            </div>
          </div>  
        </div>
        <div class="flex justify-center mt-8">
          <Pagination :links="categories.meta.links" />
        </div>
      </div>
    </div>
    <Link :href="route('article.create')" class="fixed bottom-6 right-6 p-4 bg-blue-400 hover:bg-blue-600 text-gray-100 focus:ring-4 rounded-full">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
      </svg>
    </Link>
  </AuthenticatedLayout>
</template>
