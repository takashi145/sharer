<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';


defineProps({
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
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full lg:w-2/3 mx-auto mb-4">
              <Link :href="route('post.index')" class="  text-indigo-400 hover:text-indigo-600 hover:underline">一覧へ戻る</Link>
            </div>
            <form @submit.prevent="submit" class="w-full lg:w-2/3 mx-auto space-y-5">
              <div>
                <InputLabel for="name" value="タイトル" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="タイトルを50文字以内で入力してください."
                />

                <InputError class="mt-2" :message="form.errors.name" />
              </div>

              <div>
                <InputLabel for="name" value="説明" />

                <textarea
                    id="name"
                    type="text"
                    class="w-full bg-white bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-48 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                    v-model="form.description"
                    placeholder="詳細を入力してください。"
                ></textarea>

                <InputError class="mt-2" :message="form.errors.name" />
              </div>

              <div class="text-center">
                <PrimaryButton class="w-full py-3">
                  <div class="text-center w-full">
                    Submit
                  </div>
                </PrimaryButton>
              </div>

            </form>
          </div>
            
        </div>
    </AuthenticatedLayout>
</template>
