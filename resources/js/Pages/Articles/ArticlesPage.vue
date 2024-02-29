<script setup>
import {router, Head} from "@inertiajs/vue3";
import MainLayout from "@/Components/Layouts/MainLayout.vue";
import ArticlesFilters from "@/Components/ArticlesList/ArticlesFilters.vue";
import ArticlesList from "@/Components/ArticlesList/ArticlesList.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";
import PageHeader from "@/Pages/Articles/Partials/PageHeader.vue";
import PageNavigation from "@/Pages/Articles/Partials/PageNavigation.vue";

defineProps({
  articles: {
    type: Object,
    required: true,
  },
});

const applyFilters = (filters) => {
  router.get(route('articles', filters));
};
</script>

<template>
  <MainLayout>
    <Head :title="$trans('Articles')"/>

    <PageHeader/>

    <PageNavigation current-tab="articles"/>

    <ArticlesFilters @apply="applyFilters"/>

    <ArticlesList
      class="mt-4"
      :articles="articles"
    />

    <template v-slot:sidebar>
      <AdvertPlaceholder/>
    </template>
  </MainLayout>
</template>
