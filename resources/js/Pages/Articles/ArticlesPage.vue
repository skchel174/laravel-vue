<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import PageNavigation from "@/Pages/Articles/Partials/PageNavigation.vue";
import ArticlesFilters from "@/Components/ArticleFeed/ArticlesFilters.vue";
import Placeholder from "@/Components/ArticleFeed/Placeholder.vue";

defineProps({
  articles: {
    type: Object,
    required: true,
  },
});

const currentTab = ref('articles');

const navigationTabs = {
  articles: route('articles'),
  topics: '#',
  authors: '#',
};

const applyFilters = (filters) => {
  router.get(route('articles', filters));
};
</script>

<template>
  <MainLayout>
    <header class="w-full p-4 sm:px-6 bg-white">
      <h1 class="text-xl text-gray-700 font-semibold">
        {{ $trans('All categories') }}
      </h1>
    </header>

    <PageNavigation
      :tabs="navigationTabs"
      :current-tab="currentTab"
    />

    <ArticlesFilters @apply="applyFilters"/>

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
