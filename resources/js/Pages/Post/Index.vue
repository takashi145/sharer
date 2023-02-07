<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
  posts: Array,
})
</script>

<template>
    <Head title="PostList" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">PostList</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <ul>
                  <li v-for="post in props.posts" :key="post.id">
                    <Link href="/">{{ post.title }} {{ post.user.name }}</Link>
                  </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
