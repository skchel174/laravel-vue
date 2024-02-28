<script setup>
import {Link} from "@inertiajs/vue3";
import UserAvatar from "@/Components/UserAvatar.vue";

const props = defineProps({
  author: {
    type: Object,
    required: true,
  },

  status: {
    type: String,
  },

  publishDate: {
    type: String,
  },
});
</script>

<template>
  <div class="flex items-center space-x-2">
    <Link :href="route('user', {user: author.login})">
      <UserAvatar
        size="xs"
        :src="author.avatar"
      />
    </Link>

    <div class="flex flex-wrap items-center">
      <Link
        class="text-sm text-gray-600 font-semibold !leading-4 mr-2 hover:text-sky-775 transition duration-200"
        :href="route('user', {user: author.login})"
      >
        {{ author.login }}
      </Link>

      <div class="text-xs text-gray-400 font-medium">
        <span v-if="publishDate">
          {{ $formatDate(publishDate, 'MMM D YYYY kk:mm') }}
        </span>

        <span v-else>
          {{ $trans(status) }}
        </span>
      </div>
    </div>
  </div>
</template>

