<!-- <script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import InputError from '@/Components/InputError.vue';

defineProps({
  post: Object,
  errors: Object
})

const form = useForm({
  'title': '',
  'description': '',
});

const submit = () => {
  form.post('/post', {
    preserveScroll: true,
    onSuccess: () => form.reset(),
  });
}
</script>

<template>
    <Head title="CreatePost" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">PostList</h2>
        </template>

        <div class="py-12">
            <form @submit.prevent="submit" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <input type="text" v-model="form.title" class="border">
                <InputError :message="errors.title" /><br />
                <input type="text" v-model="form.description" class="border">
                <InputError :message="errors.description" />
                <button type="submit">Submit</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template> -->

未完成