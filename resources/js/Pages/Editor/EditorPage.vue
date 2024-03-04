<script setup>
import {Head} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import useArticleForm from "@/Hooks/useArticleForm.js";
import useNotification from "@/Hooks/useNotification.js";
import ArticleEditor from "@/Pages/Editor/Partials/ArticleEditor.vue";
import ArticleSettings from "@/Pages/Editor/Partials/ArticleSettings.vue";
import Notification from "@/Components/Notification/Notification.vue";
import BackupNotice from "@/Pages/Editor/Partials/BackupNotice.vue";
import BaseLayout from "@/Components/Layouts/BaseLayout.vue";

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

const tabs = {ArticleEditor, ArticleSettings};

const currentTab = ref('ArticleEditor');

const changeTab = (tab) => {
  currentTab.value = tab;
  window.scrollTo({top: 0, behavior: "smooth"});
};

const {form, backup, update, send, restore} = useArticleForm(props.article);

const {notice, showNotification} = useNotification();

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
  <BaseLayout>
    <div class="min-h-full flex flex-col space-y-4">
      <Head :title="$trans('Article Editor')"/>

      <header class="p-4 bg-white">
        <h1 class="font-semibold text-2xl text-gray-700">
          {{ $trans('Article Editor') }}
        </h1>
      </header>

      <BackupNotice
        v-if="backupVisible"
        :backup="backup"
        @restore="restore"
        @close="backupVisible = false"
      />

      <KeepAlive>
        <component
          :is="tabs[currentTab]"
          :form="form"
          :article="article"
          @open-tab="changeTab"
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
  </BaseLayout>
</template>
