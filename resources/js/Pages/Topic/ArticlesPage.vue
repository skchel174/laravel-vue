<script setup>
import {router, Head} from "@inertiajs/vue3";
import MainLayout from "@/Components/Layouts/MainLayout.vue";
import TopicHeader from "@/Pages/Topic/Partials/TopicHeader.vue";
import TopicNavigation from "@/Pages/Topic/Partials/TopicNavigation.vue";
import ArticlesList from "@/Components/ArticlesList/ArticlesList.vue";
import ArticlesFilters from "@/Components/ArticlesList/ArticlesFilters.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";

const props = defineProps({
  topic: {
    type: Object,
    required: true,
  },

  articles: {
    type: Object,
    required: true,
  },

  subscription: {
    type: Boolean,
    required: true,
  },
});

const applyArticlesFilters = (filters) => {
  router.get(route('articles', filters));
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
      current-tab="articles"
    />

    <ArticlesFilters @apply="applyArticlesFilters"/>

    <ArticlesList
      class="mt-4"
      :articles="articles"
    />

    <template v-slot:sidebar>
      <AdvertPlaceholder/>
    </template>
  </MainLayout>
</template>
