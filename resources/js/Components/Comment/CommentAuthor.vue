<script setup>
import {Link} from "@inertiajs/vue3";
import UserAvatar from "@/Components/UserAvatar.vue";

defineProps({
  author: {
    type: Object,
    required: true,
  },

  createdDate: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <div class="flex items-center space-x-2">
    <UserAvatar
      size="xs"
      :avatar="author.avatar"
      :username="author.username"
    />

    <div class="mr-4 flex flex-wrap items-center">
      <Link
        class="text-sm text-gray-600 hover:text-sky-775 transition font-semibold mr-2"
        :href="route('user', {user: author.username})"
      >
        {{ author.username }}
      </Link>

      <span class="text-xs text-gray-400 font-medium !leading-none">
        {{ $formatDate(createdDate, 'MMM D YYYY [at] kk:mm') }}
      </span>
    </div>
  </div>
</template>
