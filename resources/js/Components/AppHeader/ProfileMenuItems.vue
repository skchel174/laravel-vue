<script setup>
import {Link} from "@inertiajs/vue3";
import Avatar from "@/Components/Avatar.vue";
import ProfileMenuItem from "@/Components/AppHeader/ProfileMenuItem.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

defineEmits(['openLanguage']);

const menu = [
  {
    url: route('user.articles', {user: props.user.login}),
    value: 'articles',
    icon: 'article',
  },
  {
    url: route('user.comments', {user: props.user.login}),
    value: 'comments',
    icon: 'question_answer',
  },
  {
    url: route('user.bookmarks.articles', {user: props.user.login}),
    value: 'bookmarks',
    icon: 'bookmarks',
  },
  {
    url: route('editor'),
    value: 'Write article',
    icon: 'post_add',
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
      <Link
        v-for="item in menu"
        :key="item.value"
        :href="item.url"
      >
        <ProfileMenuItem>
          <span class="material-icons">{{ item.icon }}</span>
          <span>{{ $trans(item.value) }}</span>
        </ProfileMenuItem>
      </Link>

      <ProfileMenuItem @click="$emit('openLanguage')">
        <span class="material-icons">language</span>
        <span>{{ $trans('Language') }}</span>
      </ProfileMenuItem>

      <Link :href="route('logout')">
        <ProfileMenuItem class="text-red-600 hover:!bg-red-50 active:!bg-red-100 hover:!text-red-700">
          <span class="material-icons">logout</span>
          <span>{{ $trans('Log out') }}</span>
        </ProfileMenuItem>
      </Link>
    </div>
  </div>
</template>

