<script setup>
import LinkCard from '@/Components/LinkCard.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

const props = defineProps({
  post: 'Object',
})

const form = useForm({});

const loading = ref(false);

const like = () => {
  loading.value = true;
  router.put(`/post/${props.post.id}/like`, {}, {
    onFinish: () => setTimeout(() => {
      loading.value = false;
    }, 3000)
  });

}

const unlike = () => {
  loading.value = true;
  router.delete(`/post/${props.post.id}/like`, {
    onFinish: () => setTimeout(() => {
      loading.value = false;
    }, 3000),
  });
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
                      <h3 class="flex justify-center items-center text-4xl mb-3 space-x-3">
                        <div>{{ post.title }}</div>
                        <div v-if="post.published" class="mt-1">
                          <div v-if="!loading" class="flex">
                            <button 
                              v-if="!post.isLiked" 
                              @click="like" 
                              :disabled="form.processing || loading"
                            > 
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-gray-400 hover:text-red-500 hover:scale-105">
                                <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                              </svg>
                            </button>
                            <button 
                              v-else 
                              @click="unlike" 
                              :disabled="form.processing || loading" 
                            > 
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-red-400 hover:text-red-500 hover:scale-105">
                                <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                              </svg>
                            </button>
                          </div>

                          <div v-else className="animate-spin h-8 w-8 border-4 border-blue-500 rounded-full border-t-transparent"></div>  
                        </div>
                      </h3>
                      <span class="inline-block h-1 w-32 rounded bg-indigo-500 mb-3"></span>
              
                      <p class="leading-relaxed text-lg mb-3">
                        {{ post.description }}
                      </p>
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
                      <LinkCard :article="article" />
                    </div>
                  </div>
                  <div v-else class="mt-24 text-center text-lg">
                    <p class="mb-8">
                      記事がありません。
                    </p>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
