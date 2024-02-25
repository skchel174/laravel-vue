<script setup>
import {router, Head} from "@inertiajs/vue3";
import Search from "@/Components/Search.vue";
import AuthorsList from "@/Components/AuthorsList/AuthorsList.vue";
import TopicHeader from "@/Pages/Topic/Partials/TopicHeader.vue";
import TopicNavigation from "@/Pages/Topic/Partials/TopicNavigation.vue";
import MainLayout from "@/Components/Layouts/MainLayout.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";

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
    <Head :title="topic.name"/>

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

    <template v-slot:sidebar>
      <AdvertPlaceholder/>
    </template>
  </MainLayout>
</template>
