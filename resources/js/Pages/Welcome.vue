<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative flex h-screen bg-gray-100 sm:pt-0 flex-col"
    >
        <div v-if="canLogin" class="z-10 hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link
                v-if="$page.props.auth.user"
                :href="route('articles.index')"
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

        <div class="relative w-full h-1/2 bg-slate-300 shadow">
            <div class="h-full flex justify-center items-center flex-col">
                <img src="/images/logo.png" alt="">
                <h3 class="text-center md:text-3xl text-gray-700">
                    役立つ記事、面白い記事をみんなに共有しよう！！
                </h3>
            </div>
        </div>
        
        <div class="w-full h-1/2 flex items-center justify-center bg-white">
            <Link :href="[(canLogin && $page.props.auth.user) ? route('articles.index') : route('login')]">
                <button class="text-2xl text-gray-100 font-semibold bg-slate-400 hover:bg-slate-500 px-5 py-3 rounded">
                    始める→
                </button>
            </Link>
        </div>
    </div>
</template>
