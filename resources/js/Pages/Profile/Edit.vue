<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const tab = ref('profile');
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
        </template> -->

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
                <Link 
                    :href="route('user.index', {'user': $page.props.auth.user.id})"
                    class="text-indigo-400 hover:text-indigo-500 underline"
                >←マイページへ戻る</Link>
                <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px">
                        <li class="mr-2">
                            <a 
                                @click="tab = 'profile'" 
                                :class="[tab === 'profile' ? 'border-blue-500 text-blue-400 cursor-default' : 'cursor-pointer hover:text-gray-800 hover:border-gray-300']"
                                class="flex items-center p-4 border-b-2 border-transparent rounded-t-lg "
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                プロフィール
                            </a>
                        </li>
                        <li class="mr-2">
                            <a 
                                @click="tab = 'password'" 
                                :class="[tab === 'password' ? 'border-blue-500 text-blue-400 cursor-default' : 'cursor-pointer hover:text-gray-800 hover:border-gray-300']"
                                class="flex items-center p-4 border-b-2 border-transparent rounded-t-lg "
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                パスワード
                            </a>
                        </li>
                        <li class="mr-2">
                            <a 
                                @click="tab = 'account'" 
                                :class="[tab === 'account' ? 'border-red-400 text-red-400 cursor-default' : 'cursor-pointer hover:text-gray-800 hover:border-gray-300']"
                                class="flex items-center p-4 border-b-2 border-transparent rounded-t-lg "
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                アカウント削除
                            </a>
                        </li>
                    </ul>
                </div>

                <div v-if="tab === 'profile'" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div v-if="tab === 'password'" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div v-if="tab === 'account'" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
