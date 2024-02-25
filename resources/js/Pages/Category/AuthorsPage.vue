<script setup>
import {router, Head} from "@inertiajs/vue3";
import MainLayout from "@/Components/Layouts/MainLayout.vue";
import PageHeader from "@/Pages/Category/Partials/PageHeader.vue";
import NavigationTabs from "@/Pages/Category/Partials/NavigationTabs.vue";
import AuthorsList from "@/Components/AuthorsList/AuthorsList.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";
import Search from "@/Components/Search.vue";

const props = defineProps({
  category: {
    type: Object,
    required: true,
  },

  authors: {
    type: Object,
    required: true,
  },

  search: {
    type: String,
    default: '',
  },
});

const searchTopics = (value) => {
  const params = {category: props.category.slug};

  if (value) {
    params.search = value;
  }

  router.get(route('category.authors', params));
};
</script>

<template>
  <MainLayout>
    <Head :title="category.name"/>

    <PageHeader :category="category"/>

    <NavigationTabs
      :category="category"
      current-tab="authors"
    />

    <Search
      :value="search"
      @search="searchTopics"
    />

    <AuthorsList
      class="mt-4"
      :authors="authors"
    />

    <template v-slot:sidebar>
      <AdvertPlaceholder/>
    </template>
  </MainLayout>
</template>
