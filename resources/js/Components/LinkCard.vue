<script setup>
import { defineProps, ref } from 'vue';
import Like from '@/Components/Like.vue';
import { Link, router } from '@inertiajs/vue3';
import { TimeDiff } from '@/utils/time-diff';
import Modal from './Modal.vue';

const props = defineProps({
  article: Object
})

const show = ref(false);

const delete_article_id = ref(null);

const isNewPost = postDay => {
  let posted = new Date(postDay); 
  let diff = new Date().getTime() - posted.getTime();
  let progress = new Date(diff);

  // 3時間以内の投稿はtrue
  if (progress.getUTCHours() <= 3) return true;

  return false;
}

const deleteArticle = () => {
  router.delete(route('article.delete', {'article': delete_article_id.value}), {
    onSuccess: () => { 
      delete_article_id.value = null;
      show.value = false;
    }
  })
}
</script>
<template>
  <div class="p-1 shadow-lg bg-white">
    <div class="flex justify-between">
      <div>
        <span class="text-sm">共有者: </span>
        <Link :href="route('user.index', article.user.id)" class=" text-gray-600 hover:text-gray-800 underline hover:cursor-pointer">{{ article.user.name }}</Link>  
      </div>
      <div v-if="isNewPost(article.updated_at)" class="text-sm text-green-500 font-semibold">
        New
      </div>
    </div>
    
    <a @click="show = true">
      <img class="h-36 w-full hover:cursor-pointer object-cover object-center mb-6 border hover:opacity-75" :src="article.thumbnail_url" alt="content">
    </a>
    <div class="px-2 h-10 overflow-y-auto">
      <h2 class="text-sm text-gray-900 font-medium title-font mb-4">{{ article.title2 }}</h2>
    </div>
    <p class="text-xs text-end">{{ TimeDiff(article.updated_at) }}</p>
  </div>

  <Modal :show="show" @close="show = false">
    <div class="p-4">
      <div>
        <img class="h-60 sm:h-80 w-full object-cover object-center border" :src="article.thumbnail_url" alt="content">
      </div>
      <div class="mb-3">
        <div class="flex justify-between my-3">
          <ul class="flex flex-wrap">
            <li v-for="tag in article.tags" :key="tag.id" class="flex items-center p-1 bg-gray-300 rounded text-sm mx-1 mb-2">
              <Link :href="`/category/${article.category_id}/article?tag=${tag.name}`" class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                </svg>
                {{ tag.name }}
              </Link>
            </li>
          </ul>
          <Like 
            :article_id="article.id" 
            :is_liked="article.is_liked"
            class="m-1"
          />  
        </div>
        <div class="text-end">
          共有者: <Link :href="route('user.index', {'user': article.user.id})" class="text-lg underline">{{ article.user.name }}</Link>
        </div>
        <h3 class="text-2xl mb-3">{{ article.title }}</h3>
        <p>
          {{ article.description }}
        </p>
      </div>
      
      <div class="text-end">
        <a 
          :href="article.url" 
          target="_blank" 
          rel="noopener noreferrer"
          class="text-blue-400 hover:text-blue-500 underline"
        >記事ページへ→</a>  
      </div>

      <div class="mt-6 flex justify-between items-center">
        <div v-if="$page.props.auth.user.id === article.user.id" class="mt-3 space-x-3 text-sm">
          <button 
            @click="delete_article_id = article.id"
            class="bg-red-400 hover:bg-red-500 text-white py-2 px-3 rounded"
          >
            削除
          </button>
          <Link
            :href="route('article.edit', {'article': article.id})"
            as="button" 
            class="bg-blue-400 hover:bg-blue-500 text-white py-2 px-3 rounded"
          >
            編集
          </Link>
        </div>

        <button @click="show=false" class=" bg-gray-300 p-3 rounded hover:bg-gray-400">閉じる</button>
      </div>
    </div>
  </Modal>

  <!--削除確認-->
  <Modal 
      :show="delete_article_id" 
      :addClass="`z-50 mt-24`"
      @close="delete_article_id = null"
    >
      <div class="p-6">
          <h2 class="text-lg font-medium text-gray-800">
              本当に削除してもよろしいですか？ 
          </h2>

          <div class="mt-6 flex justify-end">
              <SecondaryButton @click="delete_article_id = null"> キャンセル </SecondaryButton>

              <DangerButton
                  class="ml-3 text-red-500"
                  @click="deleteArticle"
              >
                  削除
              </DangerButton>
          </div>
      </div>
  </Modal>
</template>