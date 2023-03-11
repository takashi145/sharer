<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';
import LinkCard from '@/Components/LinkCard.vue';
import Modal from '@/Components/Modal.vue';
import Paginate from '@/Components/Pagination.vue';
import FollowButton from '@/Components/FollowButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import axios from 'axios';

const props = defineProps({
  articles: Array,
  user: Object,
  type: String,
  errors: Object
})

const show = ref(false);

const show_followers = ref(false);

const show_following = ref(false);

const followers = ref([]);

const follows = ref([]);

const show_followers_modal = async () => {
  show_followers.value = true;
  const res = await axios.get(`/api/user/${props.user.id}/followers`);
  followers.value = res.data;
}

const show_follows_modal = async () => {
  show_following.value = true;
  const res = await axios.get(`/api/user/${props.user.id}/follows`);
  follows.value = res.data;
}
</script>

<template>
    <Head 
      :title="[$page.props.auth.user.id === user.id ? 'MyPage' : 'UserPage']" 
    />

    <AuthenticatedLayout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="mx-6 mb-3">
                <div v-if="$page.props.auth.user.id === user.id" >
                  <h2 class="mb-3 text-xl">
                    マイページ
                  </h2>
                  <Link 
                    :href="route('profile.edit')" 
                    class="text-sm bg-gray-300 hover:bg-gray-400 px-3 py-2 rounded"
                  >
                    プロフィール編集
                  </Link>  
                </div>
                <div v-else>
                  <h2 class="mb-2">
                    <span class="text-xl mx-1 underline">{{ user.name }}</span>のユーザーページ
                  </h2>
                  <FollowButton :user_id="user.id" :is_following="user.is_following" />
                </div>
                <div class="mt-3 space-x-3">
                    <a @click="show_followers_modal" class="text-gray-600 hover:text-gray-800 hover:underline cursor-pointer">
                      {{ user.followers }} follower
                    </a>
                    <a @click="show_follows_modal" class="text-gray-600 hover:text-gray-800 hover:underline cursor-pointer">
                      {{ user.follows }} following
                    </a>
                  </div>
              </div>

              <div class="text-gray-600 body-font">
                
                <ul v-if="$page.props.auth.user.id === user.id" class="mt-6 mx-auto px-5 flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-300">
                    <li class="mr-2">
                        <Link
                          :href="route('user.index', user.id)" 
                          :only="['articles', 'type']"
                          :class="[type !== 'favorite' ? 'text-blue-600 bg-slate-300 cursor-default' : 'hover:bg-gray-200 cursor-pointer']"
                          class="inline-block p-4"
                        > 
                          投稿
                        </Link>
                    </li>
                    <li class="mr-2">
                      <Link
                        :href="route('user.index', user.id)"
                        :data="{type: 'favorite'}"
                        :only="['articles', 'type']"
                        :class="[type === 'favorite' ? 'text-blue-600 bg-slate-300 cursor-default' : 'hover:bg-gray-200 cursor-pointer']"
                        class="inline-block p-4"
                      > 
                        お気に入り
                      </Link>
                    </li>
                </ul>

                <ul v-else class="mt-6 mx-auto px-5 flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                    <li class="mr-2">
                        <div 
                          class="inline-block p-4 text-gray-700 bg-slate-300 cursor-default"
                        > 
                          {{user.name}}の投稿
                        </div>
                    </li>
                </ul>

                <div v-if="articles && articles.data.length >= 1" class="container mx-auto flex flex-wrap">
                  <div class="flex flex-wrap mx-auto w-full">
                    <div
                      v-for="article in articles.data" 
                      :key="article.id" 
                      class="p-4 w-1/2 md:w-1/3 lg:w-1/4"
                    >
                      <LinkCard :article="article" />
                    </div>
                  </div>
                </div>

                <div v-else class="text-gray-600 text-xl flex justify-center mt-48">
                  投稿がありません
                </div>
              </div>
              <div class="mt-8 flex justify-center">
                <Paginate :links="articles.meta.links" />
              </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <!--記事詳細-->
    <Modal :show="show" @close="show = false">
      <div class="text-xl m-3 border-b">
        記事のリンクを追加
      </div>
      <form @submit.prevent="update" class=" bg-white m-6 space-y-5">
        <div class="">
          <div class="flex">
            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md ">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
              </svg>
            </span>
            <input type="text" v-model="form.url" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" placeholder="URLを入力してください。">  
          </div>
          <InputError :message="errors.url"  />
        </div>
        <div class="text-end">
          <button type="submit" class="text-white bg-indigo-400 hover:bg-indigo-600 w-full py-2 rounded">Add Link</button>
        </div>
      </form>
    </Modal>

    <!--フォロワー表示-->
    <Modal :show="show_followers" maxWidth="sm" @close="show_followers = false">
      <div class="overflow-y-auto">
        <h3 class="p-3 bg-gray-100 sticky top-0 text-lg border-b">Followers</h3>
        <ul v-if="followers.length >= 1" class="px-3 h-[500px] max-w-md mx-auto divide-y divide-gray-200">
          <li v-for="follower in followers" :key="follower.id" class="py-3 sm:pb-4">
              <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </div>
                <Link :href="route('user.index', {'user': follower.id})" class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                      {{ follower.name }}
                    </p>
                </Link>
                <div class="inline-flex items-center text-base font-semibold text-gray-900">
                  <FollowButton :user_id="follower.id" :is_following="follower.is_following" />
                </div>
              </div>
          </li>
        </ul>

        <div v-else class="p-3 text-sm text-gray-700">フォロワーがいません</div>

      </div>
    </Modal>

    <!--フォローしているユーザー表示-->
    <Modal :show="show_following" maxWidth="sm" @close="show_following = false">
      <div class="overflow-y-auto">
        <h3 class="p-3 bg-gray-100 sticky top-0 text-lg border-b">Following</h3>
        <ul v-if="follows.length >= 1" class="px-3 h-[500px] max-w-md mx-auto divide-y divide-gray-200">
          <li v-for="follow in follows" :key="follow.id" class="py-3 sm:pb-4">
              <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </div>
                <Link :href="route('user.index', {'user': follow.id})" class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                      {{ follow.name }}
                    </p>
                </Link>
                <div class="inline-flex items-center text-base font-semibold text-gray-900">
                  <FollowButton :user_id="follow.id" :is_following="follow.is_following" />
                </div>
              </div>
          </li>
        </ul>
        <div v-else class="p-3 text-sm text-gray-700">フォロしていません</div>
      </div>
    </Modal>
</template>
