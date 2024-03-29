<script setup>
import {inject} from "vue";
import {Link, usePage} from "@inertiajs/vue3";
import UserAvatar from "@/Components/UserAvatar.vue";
import MenuList from "@/Components/Menu/MenuList.vue";
import MenuItem from "@/Components/Menu/MenuItem.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

const user = usePage().props.auth.user;

const {openSettings} = inject('pageSettings');
</script>

<template>
  <div>
    <div class="py-5 px-6 flex items-center space-x-2 bg-gray-50">
      <Link :href="route('user', {user: user.username})">
        <UserAvatar
          :avatar="user.avatar"
          :username="user.username"
        />
      </Link>

      <div class="text-sm text-gray-700 font-medium">
        <p v-if="user.fullname">
          {{ user.fullname }}
        </p>

        <Link
          class="text-sky-675"
          :href="route('user', {user: user.username})"
        >
          @{{ user.username }}
        </Link>
      </div>
    </div>

    <hr class="w-full bg-gray-200"/>

    <MenuList class="py-3.5">
      <Link :href="route('editor')">
        <MenuItem class="px-6 py-3.5">
          <MaterialIcon class="!text-inherit">
            post_add
          </MaterialIcon>

          <span>{{ $trans('Write article') }}</span>
        </MenuItem>
      </Link>

      <Link :href="route('user.articles', {user: user.username})">
        <MenuItem class="px-6 py-3.5">
          <MaterialIcon class="!text-inherit">
            article
          </MaterialIcon>

          <span>{{ $trans('Publications') }}</span>
        </MenuItem>
      </Link>

      <Link :href="route('user.comments', {user: user.username})">
        <MenuItem class="px-6 py-3.5 capitalize">
          <MaterialIcon class="!text-inherit">
            question_answer
          </MaterialIcon>

          <span>{{ $trans('comments') }}</span>
        </MenuItem>
      </Link>

      <Link :href="route('user.bookmarks.articles', {user: user.username})">
        <MenuItem class="px-6 py-3.5 capitalize">
          <MaterialIcon class="!text-inherit">
            bookmarks
          </MaterialIcon>

          <span>{{ $trans('bookmarks') }}</span>
        </MenuItem>
      </Link>

      <hr class="my-4 w-full bg-gray-200"/>

      <Link :href="route('settings.profile')">
        <MenuItem class="px-6 py-3.5">
          <MaterialIcon class="!text-inherit">
            manage_accounts
          </MaterialIcon>

          <span>{{ $trans('Profile settings') }}</span>
        </MenuItem>
      </Link>

      <MenuItem
        class="px-6 py-3.5"
        @click="openSettings"
      >
        <MaterialIcon class="!text-inherit">
          preview
        </MaterialIcon>

        <span>{{ $trans('Language') }}, {{ $trans('Feed') }}</span>
      </MenuItem>

      <Link :href="route('logout')">
        <MenuItem class="px-6 py-3.5">
          <MaterialIcon class="!text-inherit">
            logout
          </MaterialIcon>

          <span>{{ $trans('Log out') }}</span>
        </MenuItem>
      </Link>
    </MenuList>
  </div>
</template>

