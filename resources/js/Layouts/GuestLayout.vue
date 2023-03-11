<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-100">

        <div class="z-10 fixed top-0 right-0 px-6 py-4">
            <Link :href="route('login')" class="text-sm underline">ログイン</Link>

            <Link
                :href="route('register')"
                class="ml-4 text-sm text-gray-700 underline"
                >新規登録</Link
            >
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden"
        >
            <div class="flex justify-center">
                <Link href="/">
                    <ApplicationLogo class="w-20 h-20 fill-current text-gray-500 hover:scale-110" />
                </Link>
            </div>
            <slot />
        </div>
    </div>
</template>
