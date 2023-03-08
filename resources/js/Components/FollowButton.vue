<script setup>
import { router } from "@inertiajs/vue3"

const props = defineProps({
  user_id: Number,
  is_following: Boolean,
})

const follow = () => {
  router.post(route('user.follow', {'user': props.user_id}), {}, {

  })
}

const unfollow = () => {
  router.delete(route('user.unfollow', {'user': props.user_id}), {
    onBefore: () => confirm('フォローを解除しますか')
  })
}
</script>
<template>
  <div>
    <button
      v-if="!is_following"
      @click="follow"
      class="text-white bg-blue-400 hover:bg-blue-500 p-2 rounded shadow-lg text-sm"
    >
      + フォロー
    </button>
    <button
      v-else
      @click="unfollow"
      class="text-white bg-red-400 hover:text-red-500 p-2 rounded shadow-lg text-sm"
    >
      - フォロー解除
    </button>
  </div>
</template>