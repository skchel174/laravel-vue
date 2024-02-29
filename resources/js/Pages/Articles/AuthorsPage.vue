<script setup>
import {router, Head} from "@inertiajs/vue3";
import MainLayout from "@/Components/Layouts/MainLayout.vue";
import AuthorsList from "@/Components/AuthorsList/AuthorsList.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";
import PageHeader from "@/Pages/Articles/Partials/PageHeader.vue";
import SearchInput from "@/Components/SearchInput.vue";
import PageNavigation from "@/Pages/Articles/Partials/PageNavigation.vue";

const props = defineProps({
  authors: {
    type: Object,
    required: true,
  },

  search: {
    type: [String, null],
    required: true,
  },
});

const searchAuthors = (search) => {
  router.get(route('authors', {search}));
};
</script>

<template>
  <MainLayout>
    <Head :title="$trans('Authors')"/>

    <PageHeader/>

    <PageNavigation current-tab="authors"/>

    <SearchInput
      :value="search"
      @search="searchAuthors"
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
