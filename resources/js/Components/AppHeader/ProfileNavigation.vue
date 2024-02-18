<script setup>
import {Link} from "@inertiajs/vue3";
import Avatar from "@/Components/Avatar.vue";
import MenuList from "@/Components/Menu/MenuList.vue";
import MenuItem from "@/Components/Menu/MenuItem.vue";
import Divider from "@/Components/Divider.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import {inject} from "vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const {openLangSettings} = inject('langSettings');
</script>

<template>
  <div>
    <div class="py-5 px-6 flex items-center space-x-2 bg-gray-50">
      <Link :href="route('user', {user})">
        <Avatar :src="user.avatar"/>
      </Link>

      <div class="text-sm text-gray-700 font-medium">
        <p v-if="user.name">
          {{ user.name }}
        </p>

        <Link
          class="text-sky-700/75"
          :href="route('user', {user})"
        >
          @{{ user.login }}
        </Link>
      </div>
    </div>

    <Divider/>

    <MenuList class="py-3.5">
      <Link :href="route('editor')">
        <MenuItem class="px-6 py-3.5">
          <MaterialIcon class="text-inherit">
            post_add
          </MaterialIcon>

          <span>{{ $trans('Write article') }}</span>
        </MenuItem>
      </Link>

      <Link :href="route('user.articles', {user: props.user.login})">
        <MenuItem class="px-6 py-3.5">
          <MaterialIcon class="text-inherit">
            article
          </MaterialIcon>

          <span>{{ $trans('Publications') }}</span>
        </MenuItem>
      </Link>

      <Link :href="route('user.comments', {user: props.user.login})">
        <MenuItem class="px-6 py-3.5 capitalize">
          <MaterialIcon class="text-inherit">
            question_answer
          </MaterialIcon>

          <span>{{ $trans('comments') }}</span>
        </MenuItem>
      </Link>

      <Link :href="route('user.bookmarks.articles', {user: props.user.login})">
        <MenuItem class="px-6 py-3.5 capitalize">
          <MaterialIcon class="text-inherit">
            bookmarks
          </MaterialIcon>

          <span>{{ $trans('bookmarks') }}</span>
        </MenuItem>
      </Link>

      <Divider class="my-4"/>

      <Link :href="route('profile')">
        <MenuItem class="px-6 py-3.5">
          <MaterialIcon class="text-inherit">
            manage_accounts
          </MaterialIcon>

          <span>{{ $trans('Profile settings') }}</span>
        </MenuItem>
      </Link>

      <MenuItem
        class="px-6 py-3.5"
        @click="openLangSettings"
      >
        <MaterialIcon class="text-inherit">
          language
        </MaterialIcon>

        <span>{{ $trans('Language') }}</span>
      </MenuItem>

      <Link :href="route('logout')">
        <MenuItem class="px-6 py-3.5">
          <MaterialIcon class="text-inherit">
            logout
          </MaterialIcon>

          <span>{{ $trans('Log out') }}</span>
        </MenuItem>
      </Link>
    </MenuList>
  </div>
</template>

