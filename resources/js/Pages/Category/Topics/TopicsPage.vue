<script setup>
import {router} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import NavigationTabs from "@/Pages/Category/Partials/NavigationTabs.vue";
import TopicList from "@/Pages/Category/Topics/Partials/TopicList.vue";
import TopicsSearch from "@/Pages/Category/Topics/Partials/TopicsSearch.vue";
import PageHeader from "@/Pages/Category/Topics/Partials/PageHeader.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import TopicsPlaceholder from "@/Pages/Category/Topics/Partials/TopicsPlaceholder.vue";

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
    <PageHeader>
      {{ category.name }}
    </PageHeader>

    <NavigationTabs
      :category="category"
      current-tab="topics"
    />

    <TopicsSearch
      :value="search"
      @search="searchTopics"
    />

    <div
      v-if="topics.items.length > 0"
      class="mt-4 space-y-4"
    >
      <TopicList
        :topics="topics.items"
        :sort="sort"
        :order="order"
        @sort-list="sortList"
      />

      <Pagination
        v-if="topics.totalPages > 1"
        :total-pages="topics.totalPages"
        :current-page="topics.currentPage"
        route-name="category.topics"
        :query-params="{...topics.query, category: category.slug}"
      />
    </div>

    <TopicsPlaceholder v-else class="mt-24"/>
  </MainLayout>
</template>
