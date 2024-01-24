<script setup>
import {Head} from "@inertiajs/vue3";
import {onMounted, provide, ref} from "vue";
import useForm from "@/Hooks/Article/useForm.js";
import useBackup from "@/Hooks/Article/useBackup.js";
import useNotification from "@/Hooks/useNotification.js";
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import MainWrapper from "@/Components/MainWrapper.vue";
import Editor from "@/Pages/Editor/Partials/Editor.vue";
import Settings from "@/Pages/Editor/Partials/Settings.vue";
import Notification from "@/Components/Notification.vue";
import BackupNotice from "@/Pages/Editor/Partials/BackupNotice.vue";
import EditorHeader from "@/Pages/Editor/Partials/EditorHeader.vue";

const props = defineProps({
  article: {
    type: [Object, null],
    required: true,
  },

  status: {
    type: [String, null],
    default: null,
  },
});

const tabs = {Editor, Settings};
const currentTab = ref('Editor');
const setTab = (tab) => currentTab.value = tab;

const backupVisible = ref(false);
const {backup, makeBackup, backupForm} = useBackup();

const {form, submit} = useForm(props.article);

const updateForm = (prop, value) => {
  form[prop] = value;
  makeBackup(form);
};

const backupConfirmation = () => {
  const confirmation = confirm('Are you sure you want to restore autosave?');

  if (confirmation) {
    backupForm(form);
    backupVisible.value = false;
  }
};

const {notice, showNotification} = useNotification();

provide('showNotification', showNotification);

const sendForm = () => submit({
  onSuccess: () => showNotification('success', props.status),
  onError: () => showNotification('error', props.status),
});

onMounted(() => {
  if (backup.value) {
    backupVisible.value = true;
  }
});
</script>

<template>
  <Head title="Profile"/>

  <AppHeader/>

  <MainWrapper>
    <div class="flex-1 w-full flex flex-col space-y-4">
      <EditorHeader/>

      <BackupNotice
        v-model:visible="backupVisible"
        :backup="backup"
        @backup="backupConfirmation"
      />

      <KeepAlive>
        <component
          :is="tabs[currentTab]"
          :form="form"
          :article="article"
          @open-tab="setTab"
          @update-form="updateForm"
          @submit="sendForm"
        />
      </KeepAlive>
    </div>

    <Notification
      :type="notice.type"
      v-model:visible="notice.visible"
    >
      <p>{{ notice.message }}</p>

      <div v-if="form.hasErrors">
        <p v-for="error in form.errors">
          {{ error }}
        </p>
      </div>
    </Notification>
  </MainWrapper>
</template>
