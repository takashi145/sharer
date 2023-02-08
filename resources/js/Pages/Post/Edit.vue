<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
  post: Object,
  errors: Object
})

const show = ref(false);

const form = useForm({
  'title': props.post.title,
  'description': props.post.description,
  'published': props.post.published
});

const url_form = useForm({
  'url': ''
})

const submit = () => {
  form.put(route('post.update', props.post), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
  });
}

const deleteArticle = article_id => {
  form.post(route('article.delete', [props.post, article_id]))
}

const addArticle = () => {
  url_form.post(route('article.create', props.post), {
    onSuccess: () => {
      form.reset('url');
      show.value = false;
    }
  });
}
</script>

<template>
    <Head title="CreatePost" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">PostList</h2>
        </template>

        <div class="py-12">
          <div class=" max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form @submit.prevent="submit" class="w-full lg:w-2/3 mx-auto space-y-5">
              <div class="w-full mx-auto mb-4">
                <Link :href="route('post.show', post.id)" class="  text-indigo-400 hover:text-indigo-600 hover:underline">詳細へ戻る</Link>
              </div>
              <h3 class="text-3xl text-center border-b-2 font-serif pb-3">編集</h3>
              <div>
                <InputLabel for="title" value="タイトル" />

                <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="タイトルを50文字以内で入力してください."
                />

                <InputError class="mt-2" :message="form.errors.title" />
              </div>

              <div>
                <InputLabel for="name" value="説明" />

                <textarea
                    id="name"
                    type="text"
                    class="w-full bg-white bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-48 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                    v-model="form.description"
                    placeholder="詳細を入力してください。"
                ></textarea>

                <InputError class="mt-2" :message="form.errors.name" />
              </div>

              <div v-if="post.articles.length > 0">
                <InputLabel for="name" value="公開設定" />
                
                <div class="space-x-3 mt-2">
                  <input type="checkbox" v-model="form.published" :true-value="1">公開
                  <input type="checkbox" v-model="form.published" :true-value="0">非公開  
                </div>

                <InputError class="mt-2" :message="form.errors.published" />
              </div>
              <div v-else class="text-red-400">
                記事が登録されていないため、非公開状態となります。
              </div>

              <div class="text-center">
                <PrimaryButton class="w-full py-3">
                  <div class="text-center w-full">
                    Update
                  </div>
                </PrimaryButton>
              </div>
            </form>

            <div class="relative container px-5 mx-auto mt-24">
              <h3 class="text-3xl text-center border-b-2 font-serif pb-3">
                記事一覧
              </h3>
              <div class="text-end mr-8">
                <button @click="show = true" class="my-3 text-white bg-blue-400 hover:bg-blue-500 p-3 rounded">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                  </svg>
                  リンクを追加
                </button>
              </div>

              <Modal :show="show">
                <div class="p-3">
                  <form @submit.prevent="addArticle" class="w-full mx-auto space-y-5">
                    <h3 class="text-xl border-b-2 font-serif pb-3">リンクを追加</h3>
                    <div class="px-3 mb-8">
                      <InputLabel for="name" value="URL" class="text-lg" />

                      <p class="text-sm text-gray-800 my-3">
                        日本語などを含むurlは追加できない場合があります。
                      </p>

                      <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                          </svg>
                        </span>
                        <input type="url" v-model="url_form.url" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 " placeholder="共有するURLを入力してください.">
                      </div>

                      <InputError class="mt-2" :message="url_form.errors.url" />
                    </div>

                    <div class=" text-center space-x-8">
                      <button type="submit" class="text-white bg-indigo-400 hover:bg-indigo-600 px-4 py-2 rounded">追加</button>
                      <button type="button" @click="show = false" class="text-gray-600 ">Close</button>
                    </div>
                  </form>
      
                </div>
              </Modal>
              <div v-if="post.articles.length >= 1" class="flex flex-wrap -m-4">
                <div v-for="article in post.articles" :key="article.id" class="w-full lg:w-1/2 md:p-0">
                  <div :href="article.url" target="_blank" rel="noopener noreferrer" class="block bg-white rounded-lg p-1 shadow-lg m-8">
                    <img class="h-80 rounded w-full object-cover object-center mb-6 border" :src="article.thumbnail_url" alt="content">
                    <div class="px-3 h-24 overflow-hidden">
                      <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ article.title }}</h2>
                      <p class="leading-relaxed text-base">{{ article.description }}</p>  
                    </div>
                    <div class="p-3 mt-3">
                      <div class="text-right mb-3">
                        <a :href="article.url" target="_blank" rel="noopener noreferrer" class="text-indigo-400 hover:text-indigo-600 hover:underline">リンク先を表示→</a>
                      </div>
                      <div class="border-t-2 w-full pt-4">
                        <button @click="deleteArticle(article.id)" class="text-gray-100 bg-red-400 hover:bg-red-600 p-1 rounded w-full">削除</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-else class="my-16 text-center text-lg">
                <p class="">
                  記事がありません。<br />
                  記事がない場合は非公開状態となります。  
                </p>
              </div>
            </div>
          </div>
            
        </div>
    </AuthenticatedLayout>
</template>
