<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative flex h-screen bg-gray-100 sm:pt-0 flex-col">
        <div v-if="canLogin" class="z-10 fixed top-0 right-0 px-6 py-4">
            <Link
                v-if="$page.props.auth.user"
                :href="route('category.index')"
                class="text-sm text-gray-700 underline"
                >ホーム</Link
            >

            <template v-else>
                <Link :href="route('login')" class="text-sm underline">ログイン</Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-700 underline"
                    >新規登録</Link
                >
            </template>
        </div>

        <div class="mt-8 grid max-w-5xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-5 border-b border-gray-300 w-full lg:border-b-0">
                <ApplicationLogo class="w-32 h-32 mx-auto lg:mx-0" />
                <div class="text-center lg:text-start mb-8">
                    <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-3xl xl:text-4xl">技術記事を共有するアプリ</h1>
                    <p class="max-w-2xl mb-6 font-light text-gray-800 lg:mb-8 md:text-lg">面白い記事、役に立つ記事を皆にも共有しよう</p>
                    <Link :href="[$page.props.auth.user? '/category' : '/login']" class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-indigo-500 hover:text-indigo-600 rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 hover:underline">
                        Get started
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </Link>    
                </div>
                
            </div>
            <div class="mt-12 lg:mt-0 lg:col-span-7">
                <img :src="'/images/welcome/welcome.png'">
            </div>
        </div>
    </div>
</template>
