<script setup>
import { router } from "@inertiajs/vue3"
import { ref } from "vue";

const props = defineProps({
  user_id: Number,
  is_following: Boolean,
})

const is_following2 = ref(props.is_following);

const follow = () => {
  router.post(route('user.follow', {'user': props.user_id}), {}, {
    onSuccess: () => is_following2.value = true
  })
}

const unfollow = () => {
  router.delete(route('user.unfollow', {'user': props.user_id}), {
    onBefore: () => confirm('フォローを解除しますか'),
    onSuccess: () => is_following2.value = false
  })
}
</script>
<template>
  <div v-if="user_id !== $page.props.auth.user.id">
    <button
      v-if="!is_following2"
      @click="follow"
      class="text-white bg-blue-400 hover:bg-blue-500 p-2 rounded shadow-lg text-sm"
    >
      + フォロー
    </button>

    <button
      v-else
      @click="unfollow"
      class="text-white bg-red-400 hover:bg-red-500 p-2 rounded shadow-lg text-sm"
    >
      - フォロー解除
    </button>
  </div>
</template>