<script setup>
import {Link} from "@inertiajs/vue3";
import Avatar from "@/Components/Avatar.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

defineProps({
  author: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div class="flex">
    <div class="flex-1 flex space-x-2.5">
      <Link :href="route('user', {user: author.login})">
        <Avatar
          :src="author.avatar"
          size="md"
        />
      </Link>

      <div class="space-y-1">
        <Link
          class="mr-0.5 text-sm text-gray-800 hover:text-sky-775 transition duration-300"
          :href="route('user', {user: author.login})"
        >
          {{ author.name }}
        </Link>

        <Link
          class="text-sm text-sky-600/75"
          :href="route('user', {user: author.login})"
        >
          @{{ author.login }}
        </Link>

        <p class="text-sm text-gray-500/75">
          {{ author.about }}
        </p>

        <div class="flex lg:hidden items-center space-x-1.5">
          <MaterialIcon class="!text-2xl">
            star
          </MaterialIcon>

          <span class="text-sky-675">
            {{ $formatCount(author.articles_count) }}
          </span>
        </div>
      </div>
    </div>

    <div class="max-w-10 hidden lg:block">
      <span class="text-sky-675">
        {{ $formatCount(author.articles_count) }}
      </span>
    </div>
  </div>
</template>
