<script setup>
import {usePage} from "@inertiajs/vue3";
import UserLayout from "@/Layouts/User/UserLayout.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import ArticlesPlaceholder from "@/Pages/User/Articles/Partials/ArticlesPlaceholder.vue";

const props = defineProps({
  bookmarks: {
    type: Object,
    required: true,
  },

  user: {
    type: Object,
    required: true,
  },
});

const auth = usePage().props.auth;
</script>

<template>
  <UserLayout
    current-tab="bookmarks"
    :user="user"
  >
    <div class="mt-4">
      <div
        class="space-y-4"
        v-if="bookmarks.items.length > 0"
      >
        <ArticleCard
          v-for="article in bookmarks.items"
          :key="article.id"
          :article="article"
          :auth="auth"
        />

        <Pagination
          v-if="bookmarks.totalPages > 1"
          :query-params="bookmarks.query"
          :total-pages="bookmarks.totalPages"
          :current-page="bookmarks.currentPage"
          route-name="user.bookmarks.articles"
          :queryParams="{user: user.id}"
        />
      </div>

      <ArticlesPlaceholder
        v-else
        class="mt-16"
      />
    </div>
  </UserLayout>
</template>
