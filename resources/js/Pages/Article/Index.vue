<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps, ref } from 'vue';
import LinkCard from '@/Components/LinkCard.vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';

defineProps({
  articles: Array,
  errors: Object,
})

const form = useForm({
  url: '',
})

const show = ref(false);

const submit = () => {
  form.post(route('articles.store'), {
    onSuccess: () => show.value = false,
    onFinish: () => form.reset('url'),
  })
}
</script>
<template>
  <Head title="ArticlePage" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">UserPage</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <ul class="w-full flex flex-wrap">
          <li v-for="article in articles" :key="article.id" class="w-full md:w-1/2 lg:w-1/3 px-4 my-3">
            <LinkCard :article="article" class="w-full " />
          </li>
        </ul>
      </div>
    </div>

    <Modal :show="show" @close="show = false">
      <div class="text-xl m-3 border-b">
        記事のリンクを追加
      </div>
      <form @submit.prevent="submit" class=" bg-white m-6 space-y-5">
        <div class="">
          <div class="flex">
            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md ">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
              </svg>
            </span>
            <input type="text" v-model="form.url" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="URLを入力してください。">  
          </div>
          <InputError :message="errors.url"  />
        </div>
        <div class="text-end">
          <button type="submit" class="text-white bg-indigo-400 hover:bg-indigo-600 w-full py-2 rounded">Add Link</button>
        </div>
      </form>
    </Modal>

    <button @click="show = true" class="fixed bottom-6 right-6 p-6 bg-blue-400 hover:bg-blue-600 text-gray-100 focus:ring-4 rounded-full">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
      </svg>
    </button>

  </AuthenticatedLayout>
</template>
