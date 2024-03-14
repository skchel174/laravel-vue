<script setup>
import {inject, ref} from "vue";
import useMedia from "@/Hooks/useMedia.js";
import {router, usePage} from "@inertiajs/vue3";
import UserAvatar from "@/Components/UserAvatar.vue";
import Sidebar from "@/Components/Sidebar.vue";
import Popover from "@/Components/Popover.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";
import UserMenuItems from "@/Components/UserMenu/UserMenuItems.vue";

const user = usePage().props.auth.user;

const isTablet = useMedia('(max-width: 1024px)');

const isMenuOpen = ref(false);

const {openSettings} = inject('pageSettings');
</script>

<template>
  <div class="relative flex items-center space-x-3 text-gray-500">
    <MaterialIcon class="!text-inherit cursor-pointer">
      search
    </MaterialIcon>

    <div
      v-if="!user"
      class="flex items-center space-x-3"
    >
      <MaterialIcon
        class="!text-inherit cursor-pointer"
        @click="openSettings"
      >
        preview
      </MaterialIcon>

      <FilledButton
        color="primary"
        class="!py-1.5 !px-5"
        @click="router.get(route('login'))"
      >
        {{ $trans('Login') }}
      </FilledButton>
    </div>

    <div
      v-else
      class="flex items-center space-x-3"
    >
      <MaterialIcon class="!text-inherit cursor-pointer">
        notifications_none
      </MaterialIcon>

      <MaterialIcon
        class="!text-inherit cursor-pointer"
        @click="router.get(route('editor'))"
      >
        post_add
      </MaterialIcon>

      <UserAvatar
        class="cursor-pointer"
        v-if="user"
        size="xs"
        :avatar="user.avatar"
        :username="user.login"
        @click.stop="isMenuOpen = !isMenuOpen"
      />

      <Sidebar
        v-if="isTablet"
        v-model:open="isMenuOpen"
        side="right"
      >
        <UserMenuItems/>
      </Sidebar>

      <Popover
        v-else
        v-model:open="isMenuOpen"
        class="top-9 right-0 w-[18rem]"
      >
        <UserMenuItems/>
      </Popover>
    </div>
  </div>
</template>
