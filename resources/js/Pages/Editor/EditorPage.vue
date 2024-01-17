<script setup>
import {ref} from "vue";
import {Head, useForm} from "@inertiajs/vue3";
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import MainWrapper from "@/Components/MainWrapper.vue";
import Editor from "@/Pages/Editor/Partials/Editor.vue";
import Settings from "@/Pages/Editor/Partials/Settings.vue";

const props = defineProps({
  article: {
    type: [Object, null],
    required: true,
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
});

const tabs = {
  Editor,
  Settings,
};

const currentTab = ref('Editor');

const onSubmit = () => {
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
    .post(uri);
};
</script>

<template>
  <Head title="Profile"/>

  <AppHeader/>

  <MainWrapper>
    <form
      class="flex-1 w-full flex flex-col"
      @submit.prevent="onSubmit"
    >
      <KeepAlive>
        <component
          :is="tabs[currentTab]"
          :form="form"
          :article="article"
          @open-tab="tab => currentTab = tab"
          @update-form="(prop, val) => form[prop] = val"
        />
      </KeepAlive>
    </form>
  </MainWrapper>
</template>
