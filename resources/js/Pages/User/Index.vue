<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { defineProps, onMounted, ref } from 'vue';
import TimeDiff from '@/utils/time-diff';

const props = defineProps({
  posts: Array,
  user: Object,
  type: String
})

const deletePost = post_id => {
  router.delete(`/post/${post_id}`, {
    onBefore: () => confirm('本当に削除してもよろしいですか？')
  });
}
</script>

<template>
    <Head title="UserPage" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">UserPage</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="mx-8 mb-3">
                <div v-if="$page.props.auth.user.id === user.id" >
                  <h2 class="mb-3 text-2xl">
                    マイページ
                  </h2>
                  <Link 
                    :href="route('profile.edit')" 
                    class="bg-gray-300 hover:bg-gray-400 px-3 py-2 rounded"
                  >
                    プロフィール編集
                  </Link>  
                </div>
                <div v-else>
                  <h2 class="mb-3 text-xl">
                    <span class="text-3xl mx-1 underline">{{ user.name }}</span>のユーザーページ
                  </h2>
                </div>
              </div>

              <div class="text-gray-600 body-font">
                
                <ul v-if="$page.props.auth.user.id === user.id" class="mt-8 mx-auto px-5 flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                    <li class="mr-2">
                        <Link
                          :href="route('user.index', user.id)"
                          :data="{type: 'mine'}" 
                          :only="['posts', 'type']"
                          :class="[type !== 'favorite' ? 'text-blue-600 bg-slate-300 cursor-default' : 'hover:bg-gray-200 cursor-pointer']"
                          class="inline-block p-4 rounded-t-lg "
                        > 
                          自分の投稿
                        </Link>
                    </li>
                    <li class="mr-2">
                      <Link
                        :href="route('user.index', user.id)"
                        :data="{type: 'favorite'}"
                        :only="['posts', 'type']"
                        :class="[type === 'favorite' ? 'text-blue-600 bg-slate-300 cursor-default' : 'hover:bg-gray-200 cursor-pointer']"
                        class="inline-block p-4 rounded-t-lg "
                      > 
                        お気に入り
                      </Link>
                    </li>
                </ul>

                <ul v-else class="mt-8 mx-auto px-5 flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                    <li class="mr-2">
                        <div 
                          class="inline-block p-4 rounded-t-lg text-blue-600 bg-slate-300 cursor-default"
                        > 
                          {{user.name}}の投稿
                        </div>
                    </li>
                </ul>



                <div v-if="posts && posts.length >= 1" class="container px-5 mx-auto flex flex-wrap">
                  <div class="flex flex-wrap mx-auto w-full">
                    <div
                      v-for="post in posts" 
                      :key="post.id" 
                      class="p-4 w-full"
                      :class="[posts.length <= 1 ? 'lg:w-full' : 'lg:w-1/2']"
                    >
                      <div class="shadow-lg flex border-2 rounded-lg border-gray-200 border-opacity-50 p-3 flex-row">
                        <div class="mb-4 space-y-2">
                          <div v-if="$page.props.auth.user.id === user.id">
                            <div v-if="post.published" class=" text-green-400">公開中</div>
                            <div v-else class=" text-red-400">非公開</div>
                          </div>
                          
                          <Link :href="route('post.show', post.id)" class="hover:scale-110 hover:ring-2 w-16 h-16 sm:mr-8 sm:mb-0 mb-4 flex items-center justify-center bg-indigo-100 text-indigo-500 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                          </Link>

                          <div class="">
                            いいね数：　{{ post.like_count }}
                          </div>
                          
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

                <div v-else class="text-gray-600 text-3xl flex justify-center mt-48">
                  投稿が有りません
                </div>
              </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
