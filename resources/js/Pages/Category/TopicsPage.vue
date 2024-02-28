<script setup>
import {router, Head} from "@inertiajs/vue3";
import MainLayout from "@/Components/Layouts/MainLayout.vue";
import NavigationTabs from "@/Pages/Category/Partials/NavigationTabs.vue";
import PageHeader from "@/Pages/Category/Partials/PageHeader.vue";
import TopicsList from "@/Components/TopicsList/TopicsList.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";
import SearchInput from "@/Components/SearchInput.vue";

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

    <SearchInput
      :value="search"
      @search="searchTopics"
    />

    <TopicsList
      class="mt-4"
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
