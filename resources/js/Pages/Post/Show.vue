<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';

defineProps({
  post: 'Object',
})

</script>

<template>
    <Head title="ShowPost" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ShowPost</h2>
        </template>

        <div class="py-12">
            <div @submit.prevent="submit" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div>{{ post.title }}</div>
                <div>{{ post.description }}</div>
                <ul>
                  <li v-for="article in post.articles" :key="article.id">
                    {{ article.title }}
                    <img :src="article.thumbnail_url" :alt="article.title">
                    
                  </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
