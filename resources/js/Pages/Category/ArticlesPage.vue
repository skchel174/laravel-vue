<script setup>
import {router, Head} from "@inertiajs/vue3";
import MainLayout from "@/Components/Layouts/MainLayout.vue";
import NavigationTabs from "@/Pages/Category/Partials/NavigationTabs.vue";
import ArticlesFilters from "@/Components/ArticlesList/ArticlesFilters.vue";
import ArticlesList from "@/Components/ArticlesList/ArticlesList.vue";
import PageHeader from "@/Pages/Category/Partials/PageHeader.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";

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
    <Head :title="category.name"/>

    <PageHeader :category="category"/>

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

    <template v-slot:sidebar>
      <AdvertPlaceholder/>
    </template>
  </MainLayout>
</template>
