<script setup>
import {ref} from "vue";
import useMedia from "@/Hooks/useMedia.js";
import Sidebar from "@/Components/Sidebar.vue";
import CategoriesMenu from "@/Components/AppHeader/CategoriesMenu.vue";
import CategoriesNav from "@/Components/AppHeader/CategoriesNav.vue";
import AppHeading from "@/Components/AppHeader/AppHeading.vue";
import ProfileMenu from "@/Components/AppHeader/ProfileMenu.vue";

const isMenuOpen = ref(false);
const isTablet = useMedia('(max-width: 1024px)');
</script>

<template>
  <header class="relative border-b border-gray-200">
    <div class="w-full flex justify-center bg-gray-600">
      <div class="w-full max-w-3xl lg:max-w-5xl h-12 px-4 flex justify-between items-center">
        <div class="flex items-center">
          <span
            class="material-icons md:!hidden mr-3 !text-3xl text-white hover:text-gray-300 transition duration-300 cursor-pointer"
            @click="isMenuOpen = !isMenuOpen"
          >
            menu
          </span>

          <AppHeading/>
        </div>

        <ProfileMenu
          class="!text-gray-200"
          v-if="isTablet"
        />
      </div>
    </div>

    <nav class="hidden md:flex justify-center bg-white">
      <div class="w-full max-w-3xl lg:max-w-5xl h-12 px-4 flex justify-center lg:justify-between items-center">
        <CategoriesNav class="flex-1"/>

        <ProfileMenu v-if="!isTablet"/>
      </div>
    </nav>

    <Sidebar
      side="left"
      v-model:open="isMenuOpen"
    >
      <CategoriesMenu/>
    </Sidebar>
  </header>
</template>
