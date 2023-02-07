<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
  post: 'Object',
})

const form = useForm({});

const deletePost = () => {
  form.delete(route('post.destroy', props.post));
}

const like = () => {
  router.put(`/post/${props.post.id}/like`);
}

const unlike = () => {
  router.delete(`/post/${props.post.id}/like`);
}

</script>

<template>
    <Head title="ShowPost" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ShowPost</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-8">
              <div class="text-gray-600 body-font">
                <div class="mb-8 text-gray-600 body-font">
                  <div class="container px-5 mx-auto">
                    <div class="xl:w-1/2 lg:w-3/4 w-full mx-auto text-center">
                      <h3 class="text-4xl mb-3">{{ post.title }}</h3>
                      <span class="inline-block h-1 w-32 rounded bg-indigo-500 mb-6"></span>
                      <div class="flex justify-center flex-col">
                        <button v-if="!post.isLiked" @click="like" :disabled="form.processing" class="mx-auto w-1/3 text-white bg-green-400 hover:bg-green-500 p-2 rounded"> + 役に立った!</button>
                        <button v-else @click="unlike" :disabled="form.processing" class="mx-auto w-1/3 text-white bg-red-400 hover:bg-red-500 p-2 rounded"> - 解除</button>
                      </div>
                      <p class="leading-relaxed text-lg mb-3">
                        {{ post.description }}
                      </p>
                      <div v-if="$page.props.auth.user.id === post.user_id" class="w-full lg:w-2/3 mx-auto mb-4">
                        <Link :href="route('post.edit', post.id)" class="  text-indigo-400 hover:text-indigo-600 hover:underline">編集</Link>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="container px-5 mx-auto">
                  <div v-if="post.articles.length >= 1" class="flex flex-wrap -m-4">
                    <div 
                      v-for="article in post.articles" 
                      :key="article.id" 
                      class="w-full lg:w-1/2"
                      :class="[post.articles.length <= 1 ? 'lg:mx-auto' : '']"
                    >
                      <a :href="article.url" target="_blank" rel="noopener noreferrer" class="block bg-white rounded-lg hover:cursor-pointer m-8 p-1 shadow-lg hover:opacity-80">
                        <img class="h-80 rounded w-full object-cover object-center mb-6 border" :src="article.thumbnail_url" alt="content">
                        <div class="px-3 h-24 overflow-hidden">
                          <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ article.title }}</h2>
                          <p class="leading-relaxed text-base">{{ article.description }}</p>  
                        </div>
                      </a>
                    </div>
                  </div>
                  <div v-else class="mt-24 text-center text-lg">
                    <p class="mb-8">
                      記事がありません。<br />
                      記事がひとつもない場合は自動的に非公開状態となります。  
                    </p>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
