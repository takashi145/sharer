<script setup>
import { router } from '@inertiajs/core';
import { defineProps, ref } from 'vue';

const props = defineProps({
  article_id: Number,
  is_liked: Boolean,
})

const is_liked = ref(props.is_liked);

const loading = ref(false);

const like = async () => {
  loading.value = true;
  try {
    await axios.put(`/articles/${props.article_id}/like`);
    is_liked.value = true;
  }finally {
    setTimeout(() => {
      loading.value = false;
    }, 2000);
  }
}

const unlike = async () => {

  loading.value = true;
  try {
    await axios.delete(`/articles/${props.article_id}/like`);
    is_liked.value = false;
  }finally {
    setTimeout(() => {
      loading.value = false;
    }, 2000);
  }
}
</script>
<template>
  <div>
    <div v-if="!loading">
      <div v-if="is_liked">
        <svg @click="unlike" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-red-500 hover:scale-110 hover:cursor-pointer">
          <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
        </svg>
      </div>
      <div v-else>
        <svg @click="like" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-gray-600 hover:scale-110 hover:cursor-pointer">
          <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
        </svg>
      </div>  
    </div>
    
    <div v-else>
      <div className="animate-spin h-8 w-8 border-4 border-blue-500 rounded-full border-t-transparent"></div>
    </div>
  </div>
</template>
