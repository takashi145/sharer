<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';
import TimeDiff from '@/utils/time-diff';

const props = defineProps({
  posts: Array,
  user: Object,
})

const show = ref(false);

const deletePost = post_id => {
  router.delete(`/post/${post_id}`, {
    onBefore: () => confirm('本当に削除してもよろしいですか？')
  });
}
</script>

<template>
    <Head title="PostList" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">UserPage</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="mb-3">
                <h2 class="mb-3 text-xl">
                  <span class="text-3xl mx-1 underline">{{ user.name }}</span>のユーザーページ
                </h2>
                <Link 
                  v-if="$page.props.auth.user.id === user.id" 
                  :href="route('profile.edit')" 
                  class="bg-gray-300 hover:bg-gray-400 px-3 py-2 rounded"
                >
                  プロフィール編集
                </Link>
              </div>
              <div v-if="posts && posts.length >= 1" class="text-gray-600 body-font">
                <div class="container px-5 mx-auto flex flex-wrap">
                  <div class="flex flex-wrap mx-auto w-full">
                    <div
                      v-for="post in posts" 
                      :key="post.id" 
                      class="p-4 w-full"
                      :class="[posts.length <= 1 ? 'lg:w-full' : 'lg:w-1/2']"
                    >
                      <div class="shadow-lg flex border-2 rounded-lg border-gray-200 border-opacity-50 p-3 sm:flex-row flex-col">
                        <div class="mb-4 space-y-1">
                          <div v-if="$page.props.auth.user.id === user.id">
                            <div v-if="post.published" class=" text-green-400">公開中</div>
                            <div v-else class=" text-red-400">非公開</div>
                          </div>
                          
                          <Link :href="route('post.show', post.id)" class="hover:scale-110 hover:ring-2 w-16 h-16 sm:mr-8 sm:mb-0 mb-4 inline-flex items-center justify-center bg-indigo-100 text-indigo-500 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                          </Link>
                        </div>
                        
                        <div class="flex-grow space-y-2 mt-8">
                          <h2 class="text-gray-900 text-xl title-font font-medium">{{ post.title }}</h2>
                          <p class="text-end">更新日：{{ TimeDiff(post.updated_at) }}</p>
                      
                          <div v-if="$page.props.auth.user.id === user.id" class="flex justify-end space-x-3">
                            <Link :href="route('post.edit', post.id)" class="text-indigo-400 hover:text-indigo-500 hover:underline">編集</Link>
                            <button
                              @click="deletePost(post.id)"
                              class="text-red-400 hover:text-red-500 hover:underline"
                            >
                              削除
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-else class="text-gray-600 text-3xl flex justify-center mt-48">
                投稿が有りません
              </div>
            </div>
        </div>
        <Link :href="route('post.create')" class="fixed bottom-6 right-6">
          <button class="rounded-full bg-indigo-400 hover:bg-indigo-500 focus:border-2 border-indigo-800 p-6 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
          </button>
        </Link>
    </AuthenticatedLayout>
</template>
