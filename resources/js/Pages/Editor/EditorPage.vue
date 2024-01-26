<script setup>
import {Head} from "@inertiajs/vue3";
import {onMounted, provide, ref} from "vue";
import useForm from "@/Hooks/Article/useForm.js";
import useNotification from "@/Hooks/useNotification.js";
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import MainWrapper from "@/Components/MainWrapper.vue";
import Editor from "@/Pages/Editor/Partials/Editor.vue";
import Settings from "@/Pages/Editor/Partials/Settings.vue";
import Notification from "@/Components/Notification.vue";
import BackupNotice from "@/Pages/Editor/Partials/BackupNotice.vue";
import PageHeader from "@/Pages/Editor/Partials/PageHeader.vue";

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

const tabs = {
  Editor,
  Settings,
};

const currentTab = ref('Editor');

const {form, backup, update, send, restore} = useForm(props.article);

const {notice, showNotification} = useNotification();

provide('showNotification', showNotification);

const submit = () => send({
  onSuccess: () => showNotification('success', props.status),
  onError: () => showNotification('error', props.status),
});

const backupVisible = ref(false);

onMounted(() => {
  backupVisible.value = Boolean(backup.value);
});
</script>

<template>
  <Head :title="$trans('Article Editor')"/>

  <AppHeader/>

  <MainWrapper>
    <div class="flex-1 w-full flex flex-col space-y-4">
      <PageHeader>
        {{ $trans('Article Editor') }}
      </PageHeader>

      <BackupNotice
        v-if="backupVisible"
        :backup="backup"
        @restore="restore"
        @close="() => backupVisible = false"
      />

      <KeepAlive>
        <component
          :is="tabs[currentTab]"
          :form="form"
          :article="article"
          @open-tab="tab => currentTab = tab"
          @update-form="update"
          @submit="submit"
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
