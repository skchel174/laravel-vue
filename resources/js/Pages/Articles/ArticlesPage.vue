<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import PageNavigation from "@/Pages/Articles/Partials/PageNavigation.vue";
import ArticlesFilters from "@/Components/Article/Filters/ArticlesFilters.vue";
import ArticlesList from "@/Components/Article/ArticlesList.vue";

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

    <ArticlesList
      class="mt-4"
      :articles="articles"
    />
  </MainLayout>
</template>
