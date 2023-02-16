<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { defineProps, onMounted, ref } from 'vue';
import TimeDiff from '@/utils/time-diff';
import LinkCard from '@/Components/LinkCard.vue';
import Modal from '@/Components/Modal.vue';
import Paginate from '@/Components/Pagination.vue';

const props = defineProps({
  articles: Array,
  user: Object,
  type: String,
  errors: Object
})

const show = ref(false);

const article_id = ref(null);

const form = useForm({
  url: ''
})

const deleteArticle = article_id => {
  router.delete(`/articles/${article_id}`, {
    onBefore: () => confirm('本当に削除してもよろしいですか？')
  });
}

const update = () => {
  form.put(route('articles.update', article_id.value), {
    onSuccess: () => { 
      form.reset('url');  
      show.value = false;
    },
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
                
                <ul v-if="$page.props.auth.user.id === user.id" class="mt-8 mx-auto px-5 flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-300">
                    <li class="mr-2">
                        <Link
                          :href="route('user.index', user.id)" 
                          :only="['articles', 'type']"
                          :class="[type !== 'favorite' ? 'text-blue-600 bg-slate-300 cursor-default' : 'hover:bg-gray-200 cursor-pointer']"
                          class="inline-block p-4 rounded-t-lg "
                        > 
                          投稿
                        </Link>
                    </li>
                    <li class="mr-2">
                      <Link
                        :href="route('user.index', user.id)"
                        :data="{type: 'favorite'}"
                        :only="['articles', 'type']"
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

                <div v-if="articles && articles.data.length >= 1" class="container mx-auto flex flex-wrap">
                  <div class="flex flex-wrap mx-auto w-full">
                    <div
                      v-for="article in articles.data" 
                      :key="article.id" 
                      class="p-4 w-full md:w-1/2 lg:w-1/3"
                    >
                      <LinkCard :article="article">
                        <div v-if="$page.props.auth.user.id === user.id" class="flex justify-end space-x-3">
                          <button
                            @click="deleteArticle(article.id)"
                            class="text-sm text-red-400 hover:text-red-600 hover:underline"
                          >
                            削除
                          </button>
                        </div>
                      </LinkCard>
                    </div>

                    <Modal :show="show" @close="show = false">
                      <div class="text-xl m-3 border-b">
                        記事のリンクを追加
                      </div>
                      <form @submit.prevent="update" class=" bg-white m-6 space-y-5">
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
                  </div>
                </div>

                <div v-else class="text-gray-600 text-3xl flex justify-center mt-48">
                  投稿が有りません
                </div>
              </div>
              <div class="mt-8 flex justify-center">
                <Paginate :links="articles.meta.links" />
              </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
