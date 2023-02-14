<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

const form = useForm({
  url: '',
})

const submit = () => {
  form.post(route('articles.store'), {
    onFinish: () => form.reset('url'),
  })
}
</script>
<template>
  <Head title="ArticlePage" />

  <AuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">UserPage</h2>
    </template>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <form @submit.prevent="submit">
            <input type="url" v-model="form.url" />
            <button type="submit">Submit</button>
          </form>
        </div>
    </div>
  </AuthenticatedLayout>
</template>