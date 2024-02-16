<script setup>
import {router} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import NavigationTabs from "@/Pages/Category/Partials/NavigationTabs.vue";
import ArticlesFilters from "@/Components/Article/Filters/ArticlesFilters.vue";
import ArticlesList from "@/Components/Article/ArticlesList.vue";

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

    <ArticlesList
      class="mt-4"
      :articles="articles"
    />
  </MainLayout>
</template>
