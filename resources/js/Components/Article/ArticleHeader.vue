<script setup>
import {Link} from "@inertiajs/vue3";
import UserAvatar from "@/Components/UserAvatar.vue";

const props = defineProps({
  author: {
    type: Object,
    required: true,
  },

  publishDate: {
    type: [String, null],
  },
});
</script>

<template>
  <header class="w-full flex flex-wrap items-center justify-between">
    <div class="order-2 sm:order-1 flex items-center space-x-2">
      <Link :href="route('user', {user: author.username})">
        <UserAvatar
          size="xs"
          :avatar="author.avatar"
          :username="author.username"
        />
      </Link>

      <div class="flex flex-wrap items-end">
        <Link
          class="text-sm text-gray-600 font-semibold !leading-4 mr-2 hover:text-sky-775 transition duration-200"
          :href="route('user', {user: author.username})"
        >
          {{ author.username }}
        </Link>

        <span
          class="text-xs text-gray-400 font-medium"
          v-if="publishDate"
        >
          {{ $formatDate(publishDate, 'MMM D YYYY kk:mm') }}
        </span>
      </div>
    </div>

    <div class="order-1 sm:order-2 w-full sm:w-auto space-x-2 flex justify-end">
      <slot name="actions"/>
    </div>
  </header>
</template>

