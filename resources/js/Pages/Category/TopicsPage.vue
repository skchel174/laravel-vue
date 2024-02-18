<script setup>
import {router, Head} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import NavigationTabs from "@/Pages/Category/Partials/NavigationTabs.vue";
import PageHeader from "@/Pages/Category/Partials/PageHeader.vue";
import TopicsList from "@/Components/Topic/TopicsList.vue";
import Search from "@/Components/Search.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";

const props = defineProps({
  category: {
    type: Object,
    required: true,
  },

  topics: {
    type: Object,
    required: true,
  },

  sort: {
    type: String,
    required: true,
  },

  order: {
    type: String,
    required: true,
  },

  search: {
    type: String,
    default: '',
  }
});

const sortList = (column, order) => {
  router.get(route('category.topics', {
    category: props.category.slug,
    sort: column,
    order: order,
  }));
};

// TODO: add search
const searchTopics = (value) => {
  console.log(value);
};
</script>

<template>
  <MainLayout>
    <Head :title="category.name"/>

    <PageHeader :category="category"/>

    <NavigationTabs
      :category="category"
      current-tab="topics"
    />

    <Search
      :value="search"
      @search="searchTopics"
    />

    <TopicsList
      :topics="topics"
      :order="order"
      :sort="sort"
      @sort="sortList"
    />

    <template v-slot:sidebar>
      <AdvertPlaceholder/>
    </template>
  </MainLayout>
</template>
