<script setup>
import {Link, usePage} from "@inertiajs/vue3";
import Avatar from "@/Components/Avatar.vue";

defineProps({
  publishDate: {
    type: String,
  },
});

const user = usePage().props.auth.user;
</script>

<template>
  <div class="flex items-center space-x-2">
    <Link :href="route('user', {user: user.login})">
      <Avatar
        :src="user.avatar"
        size="xs"
      />
    </Link>

    <Link
      class="text-sm font-bold hover:text-sky-600 transition duration-300"
      :href="route('user', {user: user.login})"
    >
      {{ user.login }}
    </Link>

    <span class="text-sm text-gray-400 font-bold">
      {{ publishDate ? $formatDate(publishDate, 'MMM D YYYY [at] kk:mm') : 'Never been published' }}
    </span>
  </div>
</template>
