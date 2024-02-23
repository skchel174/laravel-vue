<script setup>
import {ref} from "vue";
import useMedia from "@/Hooks/useMedia.js";
import {router, usePage} from "@inertiajs/vue3";
import Avatar from "@/Components/Avatar.vue";
import Sidebar from "@/Components/Sidebar.vue";
import Popover from "@/Components/Popover.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import ProfileNavigation from "@/Components/AppHeader/ProfileNavigation.vue";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";

const user = usePage().props.auth.user;

const isTablet = useMedia('(max-width: 1024px)');

const isMenuOpen = ref(false);
</script>

<template>
  <div class="relative flex items-center space-x-3 text-gray-500">
    <MaterialIcon
      class="!text-inherit"
      clickable
    >
      search
    </MaterialIcon>

    <OutlineButton
      v-if="!user"
      color="primary"
      class="!py-1.25"
      @click="router.get(route('login'))"
    >
      {{ $trans('Log in') }}
    </OutlineButton>

    <div v-else class="flex items-center space-x-3">
      <MaterialIcon clickable class="!text-inherit">
        notifications_none
      </MaterialIcon>

      <MaterialIcon
        class="!text-inherit"
        clickable
        @click="router.get(route('editor'))"
      >
        post_add
      </MaterialIcon>

      <Avatar
        class="cursor-pointer"
        v-if="user"
        :src="user.avatar"
        size="xs"
        @click.stop="isMenuOpen = !isMenuOpen"
      />

      <Sidebar
        v-if="isTablet"
        side="right"
        v-model:open="isMenuOpen"
      >
        <ProfileNavigation :user="user"/>
      </Sidebar>

      <Popover
        v-else
        class="top-9 right-0 w-[18rem]"
        v-model:open="isMenuOpen"
      >
        <ProfileNavigation :user="user"/>
      </Popover>
    </div>
  </div>
</template>
