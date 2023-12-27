<script setup>
import Pagination from "@/Components/Pagination/Pagination.vue";
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import ArticlesPlaceholder from "@/Pages/User/Articles/Partials/ArticlesPlaceholder.vue";
import UserLayout from "@/Layouts/UserLayout.vue";

const props = defineProps({
  articles: {
    type: Object,
    required: true,
  },

  user: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <UserLayout
    current-tab="bookmarks"
    :user="user"
  >
    <div class="mt-4">
      <div
        class="space-y-4"
        v-if="articles.items.length > 0"
      >
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
          route-name="user.bookmarks.articles"
          :queryParams="{user: user.login}"
        />
      </div>

      <ArticlesPlaceholder
        v-else
        class="mt-16"
      />
    </div>
  </UserLayout>
</template>
