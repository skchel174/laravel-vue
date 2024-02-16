<script setup>
import {router} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import ArticlesFilters from "@/Components/ArticleFeed/ArticlesFilters.vue";
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import Placeholder from "@/Components/ArticleFeed/Placeholder.vue";
import NavigationTabs from "@/Pages/Category/Partials/NavigationTabs.vue";

const props = defineProps({
  category: {
    type: Object,
    required: true,
  },

  articles: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <MainLayout>
    <header class="w-full p-4 sm:px-6 bg-white">
      <h1 class="text-xl text-gray-700 font-semibold">
        {{ category.name }}
      </h1>
    </header>

    <NavigationTabs
      :category="category"
      current-tab="articles"
    />

    <ArticlesFilters
      @apply="filters => router.get(route('category.articles', filters))"
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

    <Placeholder v-else class="mt-24"/>
  </MainLayout>
</template>
