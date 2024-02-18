<script setup>
import {Link} from "@inertiajs/vue3";
import {provide, ref} from "vue";
import useMedia from "@/Hooks/useMedia.js";
import Sidebar from "@/Components/Sidebar.vue";
import ProfileMenu from "@/Components/AppHeader/ProfileMenu.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import LanguageSettings from "@/Components/LanguageSettings.vue";
import Modal from "@/Components/Modal.vue";
import MenuList from "@/Components/Menu/MenuList.vue";
import MenuItem from "@/Components/Menu/MenuItem.vue";

const isMenuOpen = ref(false);

const isTablet = useMedia('(max-width: 1024px)');

const isLangSettingsOpen = ref(false);
const openLangSettings = () => isLangSettingsOpen.value = true;
const closeLangSettings = () => isLangSettingsOpen.value = false;

provide('langSettings', {
  openLangSettings,
  closeLangSettings,
});
</script>

<template>
  <header class="relative border-b border-gray-200">
    <div class="w-full h-12 bg-gray-600 flex justify-center">
      <div class="w-full h-full max-w-3xl lg:max-w-6xl px-4 md:px-0 lg:px-6 flex justify-between">
        <div class="flex items-center">
          <MaterialIcon
            class="md:!hidden mr-3 !text-3xl text-white hover:!text-white"
            clickable
            @click="isMenuOpen = !isMenuOpen"
          >
            menu
          </MaterialIcon>

          <Link
            class="text-2xl text-white font-black"
            :href="route('main')"
          >
            {{ $trans('Feed') }}
          </Link>
        </div>

        <ProfileMenu
          class="!text-gray-200 hover:[&_span]:!text-gray-200"
          v-if="isTablet"
        />
      </div>
    </div>

    <nav class="hidden h-12 md:flex justify-center bg-white">
      <div class="w-full max-w-3xl lg:max-w-6xl px-4 md:px-0 lg:px-6 flex justify-center lg:justify-between">
        <div class="flex-1 flex justify-between items-center lg:justify-start lg:space-x-6">
          <Link
            v-for="item in $page.props.nav_items"
            :key="item.id"
            :href="item.url"
            class="text-sm text-gray-500/75 font-medium hover:text-sky-700/75 transition duration-200"
            :class="{'text-sky-700/75': $page.props.nav_location === item.id}"
          >
            {{ $trans(item.title) }}
          </Link>
        </div>

        <ProfileMenu v-if="!isTablet"/>
      </div>
    </nav>

    <Sidebar
      side="left"
      v-model:open="isMenuOpen"
    >
      <div class="flex flex-col">
        <h3 class="px-6 py-4 uppercase text-sm text-gray-500 font-medium">
          {{ $trans('Categories') }}
        </h3>

        <MenuList>
          <Link
            v-for="item in $page.props.nav_items"
            :key="item.id"
            :href="item.url"
          >
            <MenuItem
              class="px-6 py-3.5"
              :selected="$page.props.nav_location === item.id"
            >
              {{ $trans(item.title) }}
            </MenuItem>
          </Link>
        </MenuList>
      </div>
    </Sidebar>

    <Sidebar
      v-if="isTablet"
      v-model:open="isLangSettingsOpen"
      side="top"
    >
      <LanguageSettings @close="closeLangSettings"/>
    </Sidebar>

    <Modal
      v-else
      max-width="sm"
      v-model:open="isLangSettingsOpen"
    >
      <LanguageSettings @close="closeLangSettings"/>
    </Modal>
  </header>
</template>
