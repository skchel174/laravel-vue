<script setup>
import {ref} from "vue";
import {Link, router, usePage} from "@inertiajs/vue3";
import useMedia from "@/Hooks/useMedia.js";
import Avatar from "@/Components/Avatar.vue";
import Modal from "@/Components/Modal.vue";
import Sidebar from "@/Components/Sidebar.vue";
import Popover from "@/Components/Popover.vue";
import ProfileMenuItems from "@/Components/AppHeader/ProfileMenuItems.vue";
import ProfileMenuIcon from "@/Components/AppHeader/ProfileMenuIcon.vue";
import PrimaryOutlineButton from "@/Components/Buttons/PrimaryOutlineButton.vue";
import LanguageSettings from "@/Components/LanguageSettings.vue";

defineEmits(['toggleMenu']);

const user = usePage().props.auth.user;

const isTablet = useMedia('(max-width: 1024px)');

const isMenuOpen = ref(false);

const isLanguageMenuOpen = ref(false);

const openLanguageMenu = () => {
  isMenuOpen.value = false;
  isLanguageMenuOpen.value = true;
}

const closeLanguageMenu = () => {
  isLanguageMenuOpen.value = false;
};
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
      {{ $trans('Log in') }}
    </PrimaryOutlineButton>

    <div
      class="flex items-center space-x-3"
      v-else
    >
      <ProfileMenuIcon>
        notifications_none
      </ProfileMenuIcon>

      <Link :href="route('editor')">
        <ProfileMenuIcon>
          post_add
        </ProfileMenuIcon>
      </Link>

      <Avatar
        class="cursor-pointer"
        v-if="user"
        :src="user.avatar"
        size="xs"
        @click.stop="() => isMenuOpen = !isMenuOpen"
      />

      <Sidebar
        v-if="isTablet"
        side="right"
        v-model:open="isMenuOpen"
      >
        <ProfileMenuItems
          :user="user"
          @open-language="openLanguageMenu"
        />
      </Sidebar>

      <Popover
        v-else
        class="top-10 right-0 w-[18rem]"
        v-model:open="isMenuOpen"
      >
        <ProfileMenuItems
          :user="user"
          @open-language="openLanguageMenu"
        />
      </Popover>
    </div>

    <Sidebar
      v-if="isTablet"
      v-model:open="isLanguageMenuOpen"
      side="top"
    >
      <LanguageSettings @close="closeLanguageMenu"/>
    </Sidebar>

    <Modal
      v-else
      v-model:open="isLanguageMenuOpen"
      max-width="sm"
    >
      <LanguageSettings @close="closeLanguageMenu"/>
    </Modal>
  </div>
</template>
