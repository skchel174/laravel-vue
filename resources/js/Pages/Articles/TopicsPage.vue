<script setup>
import {Head, router} from "@inertiajs/vue3";
import MainLayout from "@/Components/Layouts/MainLayout.vue";
import SearchInput from "@/Components/SearchInput.vue";
import TopicsList from "@/Components/TopicsList/TopicsList.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";
import PageHeader from "@/Pages/Articles/Partials/PageHeader.vue";
import PageNavigation from "@/Pages/Articles/Partials/PageNavigation.vue";

defineProps({
  topics: {
    type: Object,
    required: true,
  },

  subscriptions: {
    type: Array,
    required: true,
  },

  order: {
    type: String,
    required: true,
  },

  sort: {
    type: String,
    required: true,
  },

  search: {
    type: [String, null],
    required: true,
  },
});

const sortTopics = (sort, order) => {
  router.get(route('topics', {sort, order}));
};
</script>

<template>
  <MainLayout>
    <Head :title="$trans('Topics')"/>

    <PageHeader/>

    <PageNavigation current-tab="topics"/>

    <SearchInput :value="search"/>

    <TopicsList
      class="mt-4"
      :topics="topics"
      :subscriptions="subscriptions"
      :sort="sort"
      :order="order"
      @sort="sortTopics"
    />

    <template v-slot:sidebar>
      <AdvertPlaceholder/>
    </template>
  </MainLayout>
</template>
