<script setup>
import {provide, ref} from "vue";
import {Head, useForm} from "@inertiajs/vue3";
import useNotification from "@/Hooks/useNotification.js";
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import MainWrapper from "@/Components/MainWrapper.vue";
import Editor from "@/Pages/Editor/Partials/Editor.vue";
import Settings from "@/Pages/Editor/Partials/Settings.vue";
import Notification from "@/Components/Notification.vue";

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

const form = useForm({
  text: props.article?.text ?? '',
  title: props.article?.title ?? '',
  summary: props.article?.summary ?? '',
  tags: props.article?.tags ?? [],
  topics: props.article?.topics ?? [],
  difficulty: props.article?.difficulty ?? null,
  image: undefined,
  media: null,
  status: null,
});

const tabs = {Editor, Settings};

const currentTab = ref('Editor');

const {notice, showNotification} = useNotification();

provide('showNotification', showNotification);

const sendFrom = () => {
  const uri = props.article
    ? route('article.update', {article: props.article.id})
    : route('article.create');

  form
    .transform(payload => ({
      ...payload,
      tags: form.tags.map(tag => tag.id),
      topics: form.topics.map(topic => topic.id),
      _method: props.article ? 'patch' : 'post',
    }))
    .post(uri, {
      onSuccess: () => showNotification('success', props.status),
      onError: () => showNotification('error', props.status),
    });
};
</script>

<template>
  <Head title="Profile"/>

  <AppHeader/>

  <MainWrapper>
    <div class="flex-1 w-full flex flex-col">
      <KeepAlive>
        <component
          :is="tabs[currentTab]"
          :form="form"
          :article="article"
          @open-tab="tab => currentTab = tab"
          @update-form="(prop, val) => form[prop] = val"
          @submit="sendFrom"
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
