<script setup>
import FeedLayout from "@/Layouts/FeedLayout.vue";
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import PageHeader from "@/Pages/User/Articles/Partials/PageHeader.vue";

defineProps({
  articles: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <FeedLayout>
    <div class="space-y-4">
      <PageHeader/>

      <ArticleCard
        v-for="article in articles.items"
        :key="article.id"
        :article="article"
      />

      <Pagination
        v-if="articles.totalPages > 1"
        :query-params="articles.query"
        :total-pages="articles.totalPages"
        :current-page="articles.currentPage"
        route-name="articles.feed"
      />
    </div>
  </FeedLayout>
</template>
