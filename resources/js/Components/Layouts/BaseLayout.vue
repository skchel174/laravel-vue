<script setup>
import {provide, ref} from "vue";
import useMedia from "@/Hooks/useMedia.js";
import useNotification from "@/Hooks/useNotification.js";
import AppHeader from "@/Components/AppHeader.vue";
import AppNotification from "@/Components/AppNotification.vue";
import Sidebar from "@/Components/Sidebar.vue";
import Modal from "@/Components/Modal.vue";
import LanguageSettings from "@/Components/LanguageSettings.vue";
import AppNavigation from "@/Components/AppNavigation.vue";

const {notice, showNotification} = useNotification();

provide('notify', showNotification);

const isLangSettingsOpen = ref(false);
const openLangSettings = () => isLangSettingsOpen.value = true;
const closeLangSettings = () => isLangSettingsOpen.value = false;

provide('langSettings', {openLangSettings, closeLangSettings});

const isTablet = useMedia('(max-width: 1024px)');
</script>

<template>
  <AppHeader/>

  <AppNavigation/>

  <main class="flex-1 lg:mt-4 mx-auto w-full max-w-3xl lg:max-w-6xl px-0 lg:px-6">
    <slot/>
  </main>

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

  <AppNotification
    :type="notice.type"
    v-model:visible="notice.visible"
  >
    {{ $trans(notice.message) }}
  </AppNotification>
</template>
