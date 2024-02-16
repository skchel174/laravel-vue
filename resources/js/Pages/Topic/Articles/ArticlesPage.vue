<script setup>
import {router} from "@inertiajs/vue3";
import TopicLayout from "@/Pages/Topic/TopicLayout.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import ArticlesFilters from "@/Components/ArticleFeed/ArticlesFilters.vue";

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
  <TopicLayout
    :topic="topic"
    :subscription="subscription"
    current-tab="articles"
  >
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
  </TopicLayout>
</template>
