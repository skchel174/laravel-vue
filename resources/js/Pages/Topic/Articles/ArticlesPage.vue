<script setup>
import {router} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination/Pagination.vue";
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import ArticlesFilters from "@/Components/ArticleFeed/ArticlesFilters.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import TopicHeader from "@/Pages/Topic/Partials/TopicHeader.vue";
import TopicNavigation from "@/Pages/Topic/Partials/TopicNavigation.vue";

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
</script>

<template>
  <MainLayout>
    <TopicHeader
      :topic="topic"
      :subscription="subscription"
    />

    <TopicNavigation
      :topic="topic"
      current-tab="articles"
    />

    <ArticlesFilters
      @apply="filters => router.get(route('articles', filters))"
    />

    <div
      class="mt-4 space-y-4"
      v-if="articles.items.length > 0"
    >
      <ArticleCard
        v-for="article in articles.items"
        :key="article.id"
        :article="article"
      />

      <Pagination :items="articles"/>
    </div>
  </MainLayout>
</template>
