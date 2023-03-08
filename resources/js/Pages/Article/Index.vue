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
  // articles: Array,
  // errors: Object,
  // tag_name: Object,
  // keyword: String,
  tags: Array,
})

const form = useForm({
  title2: '',
  url: '',
  tags: [],
})

const show = ref(false);

const message = ref('');

const tag = ref('');

const submit = () => {
  form.post(route('articles.store'), {
    onSuccess: () => {
      form.reset();
      show.value = false;
    },
  })
}

const addTag = () => {
  if(!tag.value) {
    message.value = 'タグ名が入力されていません。';
    return;
  }
  if(form.tags.length >= 5) {
    message.value = '追加できるタグは5つまでです。';
    return;
  }
  
  form.tags.push(tag.value)

  tag.value = '';
}

const deleteTag = name => {
  form.tags = form.tags.filter(t => {
    return t !== name;
  })
}
</script>
<template>
  <Head title="ArticlePage" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">UserPage</h2>
    </template>

    <div class="mt-8 pb-24">
      <!-- <div class="w-full md:w-2/3 mx-auto mb-8">
        <SearchInput :keyword="keyword" class="mx-8" />
      </div>

      <div v-if="tag_name" class="flex mx-8 items-center">
        <h2 class="underline text-xl flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
          </svg>
          {{ tag_name }}
        </h2>
        <Link :href="route('articles.index')">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-2 text-gray-500 hover:text-gray-700 hover:scale-105">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </Link>
      </div> -->

      <div class="max-w-7xl mx-auto sm:px-4">
        <div v-if="tags.data.length >= 1">
          <div v-for="tag in tags.data" :key="tag.id" class="overflow-x-auto mx-4 mb-8 pb-8 border-b">
            <h3 class="text-xl ml-2">
              {{ tag.name }}
              <Link href="/" class="mx-2 text-sm text-blue-400 hover:text-blue-600 underline">すべて見る→</Link>
            </h3>
            <ul v-if="tag.articles.length >= 1" class="flex min-w-max mt-4">
              <li v-for="article in tag.articles" :key="article.id" class="w-64">
                <LinkCard :article="article" class="mx-3" />
              </li>
            </ul>
          </div>  
        </div>
        
        
        <div v-else class="text-xl text-gray-700 flex justify-center mt-24">
          記事がありません。
        </div>
        <div class="flex justify-center mt-8">
          <Pagination :links="tags.meta.links" />
        </div>
      </div>
    </div>

    <!--記事作成モーダル-->
    <Modal :show="show" @close="show = false; form.reset();">
      <div class="text-xl m-3 border-b">
        記事を共有
      </div>
      <form class=" bg-white m-6 space-y-5">
        <div class="space-y-4">
          <div>
            <label for="">Title</label>
            <div class="flex mb-1">
              <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
              </span>
              <input type="text" v-model="form.title2" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="タイトルを入力してください。">    
            </div>
            <InputError :message="errors.title2"  />
          </div>
          <div>
            <label for="">URL</label>
            <div class="flex mb-1">
              <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                </svg>
              </span>
              <input type="text" v-model="form.url" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="URLを入力してください。">    
            </div>
            <InputError :message="errors.url"  />
          </div>

          <div>
            <label for="">Tag</label>
            <p class="text-red-400 text-sm">{{ message }}</p>
            <div class="relative flex mb-1">
              <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                </svg>
              </span>
              <input type="text" v-model="tag" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-3" placeholder="タグ名を入力してください。">    
              <button type="button" :disabled="!tag" @click="addTag" class="text-white absolute right-2.5 bottom-1 bg-slate-600 hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Add</button>
            </div>
            <ul class="flex ">
              <li v-for="t in form.tags" :key="t" class="">
                <span id="badge-dismiss-dark" class="inline-flex items-center px-2 py-1 mr-2 text-sm font-medium text-gray-800 bg-gray-100 rounded dark:bg-gray-700 dark:text-gray-300">
                  {{ t }}
                  <button 
                    type="button" 
                    @click="deleteTag(t)" 
                    class="inline-flex items-center p-0.5 ml-2 text-sm text-gray-400 bg-transparent rounded-sm hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-gray-300"
                  >
                      <svg aria-hidden="true" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                  </button>
                </span>
              </li>
            </ul>
          </div>
        </div>
        <div class="text-end">
          <button 
            type="button" 
            @click="submit" 
            :disabled="!form.url || !form.title2"
            :class="[!form.url || !form.title2 ? 'bg-gray-400' : 'bg-indigo-400 hover:bg-indigo-600']"
            class="text-white w-full py-2 rounded"
          >
            Submit
          </button>
        </div>
      </form>
    </Modal>
    <button @click="show = true; errors = {}" class="fixed bottom-6 right-6 p-4 bg-blue-400 hover:bg-blue-600 text-gray-100 focus:ring-4 rounded-full">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
      </svg>
    </button>
    <!---->

  </AuthenticatedLayout>
</template>
