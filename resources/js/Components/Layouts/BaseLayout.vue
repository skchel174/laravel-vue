<script setup>
import {provide, ref} from "vue";
import useMedia from "@/Hooks/useMedia.js";
import AppHeader from "@/Components/AppHeader.vue";
import Sidebar from "@/Components/Sidebar.vue";
import Modal from "@/Components/Modal.vue";
import AppNavigation from "@/Components/AppNavigation.vue";
import PageSettings from "@/Components/PageSettings/PageSettings.vue";
import NotificationWrapper from "@/Components/Notification/NotificationWrapper.vue";

const isSettingsOpen = ref(false);
const openSettings = () => isSettingsOpen.value = true;
const closeSettings = () => isSettingsOpen.value = false;

provide('pageSettings', {openSettings, closeSettings});

const isTablet = useMedia('(max-width: 1024px)');
</script>

<template>
  <NotificationWrapper>
    <AppHeader/>

    <AppNavigation/>

    <main class="flex-1 lg:mt-4 mx-auto w-full max-w-3xl lg:max-w-6xl px-0 lg:px-6">
      <slot/>
    </main>

    <Sidebar
      v-if="isTablet"
      v-model:open="isSettingsOpen"
      side="top"
    >
      <PageSettings @close="closeSettings"/>
    </Sidebar>

    <Modal
      v-else
      max-width="sm"
      v-model:open="isSettingsOpen"
    >
      <PageSettings @close="closeSettings"/>
    </Modal>
  </NotificationWrapper>
</template>
