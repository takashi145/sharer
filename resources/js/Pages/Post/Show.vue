<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
  post: 'Object',
})

const form = useForm({});

const form2 = useForm({
  url: '',
})

const deletePost = () => {
  form.delete(route('post.destroy', props.post));
}

const addArticle = () => {
  form2.post(route('article.create', props.post));
}

const deleteArticle = article_id => {
  form.post(route('article.delete', [props.post, article_id]))
}

</script>

<template>
    <Head title="ShowPost" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ShowPost</h2>
        </template>

        <div class="py-12">
            <form @submit.prevent="addArticle" class="mb-8 border p-8 space-y-4">
              <input type="url" v-model="form2.url" class="w-full">
              <button class="text-white bg-indigo-400 hover:bg-indigo-500 w-full p-2 rounded">Add</button>
            </form>
            <button @click="deletePost" class="text-red-400">削除</button>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div>{{ post.title }}</div>
                <div>{{ post.description }}</div>
                <ul>
                  <li v-for="article in post.articles" :key="article.id">
                    <button @click="deleteArticle(article.id)" class="text-red-400">delete</button>
                    {{ article.title }}
                    <img :src="article.thumbnail_url" :alt="article.title">
                  </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
