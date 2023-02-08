<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';
import TimeDiff from '@/utils/time-diff';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
  posts: Array,
  errors: Object,
})

const show = ref(false);

const form = useForm({
  'title': '',
  'description': '',
});

const submit = () => {
  form.post('/post', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      show.value = false;
    },
    
  });
}
</script>

<template>
    <Head title="PostList" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">PostList</h2>
        </template>

        <div v-if="posts && posts.length >= 1" class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="text-gray-600 body-font">
                <div class="container px-5 mx-auto flex flex-wrap">
                  <div class="flex flex-wrap mx-auto w-full">
                    <Link 
                      :href="route('post.show', post.id)"
                      v-for="post in posts" 
                      :key="post.id" 
                      class="p-4 w-full"
                      :class="[posts.length <= 1 ? 'lg:w-full' : 'lg:w-1/2']"
                    >
                      <div class="bg-white hover:ring-2 shadow-lg flex border-2 border-gray-200 border-opacity-50 p-8 sm:flex-row flex-col">
                        <div class="w-16 h-16 sm:mr-8 sm:mb-0 mb-4 inline-flex items-center justify-center bg-indigo-100 text-indigo-500 flex-shrink-0">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                          </svg>
                        </div>
                        <div class="flex-grow">
                          <p class="mb-3">
                            投稿者：
                            <Link :href="route('user.index', post.user.id)" class="hover:underline text-xl">{{ post.user.name }}</Link>
                          </p>
                          <h2 class="text-gray-900 text-xl title-font font-medium mb-3">{{ post.title }}</h2>
                          <p class="text-end">更新日：{{ TimeDiff(post.updated_at) }}</p>
                        </div>
                      </div>
                    </Link>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div v-else class="text-gray-600 text-3xl flex justify-center mt-48">
          投稿が有りません
        </div>
        <button @click="show = true" class="fixed bottom-6 right-6">
          <button class="rounded-full bg-indigo-400 hover:bg-indigo-500 focus:border-2 border-indigo-800 p-6 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
          </button>
        </button>

        <Modal :show="show">
          <div class="p-8">
            <button @click="show = false" class="absolute right-3 top-3">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
            <h2 class="text-2xl mb-3">記事を作成</h2>
            <form @submit.prevent="submit" class="w-full mx-auto space-y-5">
                <div>
                  <InputLabel for="name" value="タイトル" />

                  <TextInput
                      id="name"
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

                  <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="text-center">
                  <PrimaryButton class="w-full py-3">
                    <div class="text-center w-full">
                      Submit
                    </div>
                  </PrimaryButton>
                </div>
            </form>
          </div>
          
        </Modal>
        
    </AuthenticatedLayout>
</template>
