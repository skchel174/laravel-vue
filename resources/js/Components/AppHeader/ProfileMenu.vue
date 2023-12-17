<script setup>
import {ref} from "vue";
import useMedia from "@/Hooks/useMedia.js";
import Avatar from "@/Components/Avatar.vue";
import Sidebar from "@/Components/Sidebar.vue";
import Popover from "@/Components/Popover.vue";
import ProfileMenuItems from "@/Components/AppHeader/ProfileMenuItems.vue";
import ProfileMenuIcon from "@/Components/AppHeader/ProfileMenuIcon.vue";

defineProps({
  user: {
    type: Object,
    required: true,
  },
});

defineEmits(['toggleMenu']);

const isMenuOpen = ref(false);

const isTablet = useMedia('(max-width: 1024px)');
</script>

<template>
  <div class="relative flex items-center space-x-3 text-gray-500 transition duration-300">
    <ProfileMenuIcon>
      search
    </ProfileMenuIcon>

    <ProfileMenuIcon>
      notifications_none
    </ProfileMenuIcon>

    <ProfileMenuIcon>
      post_add
    </ProfileMenuIcon>

    <Avatar
      v-if="user"
      :value="user.avatar"
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
</template>
