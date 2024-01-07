<script setup>
import {Link} from "@inertiajs/vue3";
import Avatar from "@/Components/Avatar.vue";
import ProfileMenuLink from "@/Components/AppHeader/ProfileMenuLink.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const menu = [
  {
    url: route('user.articles', {user: props.user.login}),
    value: 'Articles',
    icon: 'article',
  },
  {
    url: route('user.comments', {user: props.user.login}),
    value: 'Comments',
    icon: 'question_answer',
  },
  {
    url: route('user.bookmarks.articles', {user: props.user.login}),
    value: 'Bookmarks',
    icon: 'bookmarks',
  },
  {
    url: route('profile'),
    value: 'Profile settings',
    icon: 'manage_accounts',
  },
];
</script>

<template>
  <div>
    <div class="p-4 sm:px-6 flex items-center space-x-4 bg-gray-50 border-b border-gray-200">
      <Link :href="route('user', {user})">
        <Avatar
          v-if="user"
          :src="user.avatar"
          size="sm"
        />
      </Link>

      <div class="text-sm text-gray-700 font-medium">
        <p
          class="leading-tight"
          v-if="user.name"
        >
          {{ user.name }}
        </p>

        <Link
          class="text-sky-600 hover:text-sky-500 transition duration-300"
          :href="route('user', {user})"
        >
          @{{ user.login }}
        </Link>
      </div>
    </div>

    <div class="py-4">
      <ProfileMenuLink
        v-for="item in menu"
        :key="item.value"
        :href="item.url"
      >
        <span class="material-icons">{{ item.icon }}</span>
        <span>{{ item.value }}</span>
      </ProfileMenuLink>

      <ProfileMenuLink
        class="text-red-600 hover:!bg-red-50 active:!bg-red-100 hover:!text-red-700"
        :href="route('logout')"
      >
        <span class="material-icons">logout</span>
        <span>Log out</span>
      </ProfileMenuLink>
    </div>
  </div>
</template>

