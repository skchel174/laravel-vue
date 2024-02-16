<script setup>
import {router} from "@inertiajs/vue3";
import Search from "@/Components/Search.vue";
import AuthorsList from "@/Components/Author/AuthorsList.vue";
import TopicHeader from "@/Pages/Topic/Partials/TopicHeader.vue";
import TopicNavigation from "@/Pages/Topic/Partials/TopicNavigation.vue";
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
  topic: {
    type: Object,
    required: true,
  },

  subscription: {
    type: Boolean,
    required: true,
  },

  authors: {
    type: Object,
    required: true,
  },

  search: {
    type: String,
  },
});

const searchAuthors = (value) => {
  const params = {topic: props.topic.slug};

  if (value) {
    params.search = value;
  }

  router.get(route('topic.authors', params));
};
</script>

<template>
  <MainLayout>
    <TopicHeader
      :topic="topic"
      :subscription="subscription"
    />

    <TopicNavigation
      :topic="topic"
      current-tab="authors"
    />

    <Search
      :value="search"
      @search="searchAuthors"
    />

    <AuthorsList
      class="mt-4"
      :authors="authors"
    />
  </MainLayout>
</template>
