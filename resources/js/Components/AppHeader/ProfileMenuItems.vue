<script setup>
import {Link} from "@inertiajs/vue3";
import Avatar from "@/Components/Avatar.vue";
import ProfileMenuLink from "@/Components/AppHeader/ProfileMenuLink.vue";

defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const menu = [
  {url: '#', value: 'Publications', icon: 'article'},
  {url: '#', value: 'Comments', icon: 'question_answer'},
  {url: '#', value: 'Bookmarks', icon: 'bookmarks'},
  {url: route('profile'), value: 'Profile settings', icon: 'manage_accounts'},
];
</script>

<template>
  <div>
    <div class="p-4 sm:px-6 flex items-center space-x-4 bg-gray-50 border-b border-gray-200">
      <div class="cursor-pointer">
        <Avatar
          v-if="user"
          :value="user.avatar"
        />
      </div>

      <Link
        class="text-sm text-sky-500 font-medium cursor-pointer hover:text-sky-600 transition duration-300"
        :href="route('user', {user})"
      >
        {{ user.name }}
      </Link>
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
        class="text-red-600 hover:bg-red-50 active:bg-red-100 hover:text-red-700"
        :href="route('logout')"
      >
        <span class="material-icons">logout</span>
        <span>Log out</span>
      </ProfileMenuLink>
    </div>
  </div>
</template>

