<script setup>
import {ref} from "vue";
import {Link, router, usePage} from "@inertiajs/vue3";
import useMedia from "@/Hooks/useMedia.js";
import Avatar from "@/Components/Avatar.vue";
import Sidebar from "@/Components/Sidebar.vue";
import Popover from "@/Components/Popover.vue";
import ProfileMenuItems from "@/Components/AppHeader/ProfileMenuItems.vue";
import ProfileMenuIcon from "@/Components/AppHeader/ProfileMenuIcon.vue";
import PrimaryOutlineButton from "@/Components/Buttons/PrimaryOutlineButton.vue";

defineEmits(['toggleMenu']);

const user = usePage().props.auth.user;

const isMenuOpen = ref(false);

const isTablet = useMedia('(max-width: 1024px)');
</script>

<template>
  <div class="relative flex items-center space-x-3 text-gray-500 transition duration-300">
    <ProfileMenuIcon>
      search
    </ProfileMenuIcon>

    <PrimaryOutlineButton
      class="!py-1.25"
      v-if="!user"
      @click="router.get(route('login'))"
    >
      Login
    </PrimaryOutlineButton>

    <div
      class="flex items-center space-x-3"
      v-else
    >
      <ProfileMenuIcon>
        notifications_none
      </ProfileMenuIcon>

      <Link :href="route('article.editor')">
        <ProfileMenuIcon>
          post_add
        </ProfileMenuIcon>
      </Link>

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
        <ProfileMenuItems :user="user"/>
      </Sidebar>

      <Popover
        v-else
        class="top-10 right-0 w-[18rem]"
        v-model:open="isMenuOpen"
      >
        <ProfileMenuItems :user="user"/>
      </Popover>
    </div>
  </div>
</template>
