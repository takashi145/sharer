<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps, ref } from 'vue';
import LinkCard from '@/Components/LinkCard.vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import SearchInput from '@/Components/SearchInput.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
  categories: Array,
  article: Object,
  errors: Object
})

const form = useForm({
  category: props.article.category_id,
  title2: props.article.title2,
  url: props.article.url,
  tags: props.article.tags.join(' '),
})

const message = ref('');

const tag = ref('');

const update = () => {
  form.put(route('article.update', {'article': props.article.id}), {
    onSuccess: () => {
      form.reset();
    },
  })
}
</script>
<template>
  <Head title="CreateArticle" />

  <AuthenticatedLayout>
    <div class="mt-12 pb-24">
      <form class=" bg-white m-6 space-y-4 p-8 max-w-lg mx-auto rounded shadow-lg">
        <Link 
          :href="route('user.index', {'user': article.user_id})" 
          class="text-blue-400 hover:text-blue-500 underline"
        >←マイページに戻る</Link>
        <h3>記事を更新</h3>
        <div class="space-y-4">
          <div>
            <label for="">Category</label>
            <div class="flex mb-1">
              <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
              </span>
              <select v-model="form.category" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5">
                <option value="" class="text-gray-500">カテゴリーを選択してください。</option>
                <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
              </select>
            </div>
            <InputError :message="errors.title2"  />
          </div>
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
            <p class="text-sm text-gray-600">タグは空白区切りで5つまで追加できます。</p>
            <div class="relative flex mb-1">
              <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                </svg>
              </span>
              <input type="text" v-model="form.tags" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="タグ名を空白区切りで入力してください。">    
            </div>
          </div>
        </div>
        <div class="text-end">
          <button 
            type="button" 
            @click="update" 
            :disabled="!form.url || !form.title2 || !form.category"
            :class="[!form.url || !form.title2 || !form.category ? 'bg-gray-400/50' : 'bg-indigo-400 hover:bg-indigo-600']"
            class="text-white w-full py-2 rounded"
          >
            更新する
          </button>
        </div>
      </form>
    </div> 
  </AuthenticatedLayout>
</template>
