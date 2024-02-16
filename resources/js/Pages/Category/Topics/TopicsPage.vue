<script setup>
import {router, Link} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import NavigationTabs from "@/Pages/Category/Partials/NavigationTabs.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import PageHeader from "@/Pages/Category/Partials/PageHeader.vue";
import PageHeading from "@/Pages/Category/Partials/PageHeading.vue";
import Search from "@/Pages/Category/Partials/Search.vue";
import List from "@/Pages/Category/Partials/List.vue";
import ListColumns from "@/Pages/Category/Partials/ListColumns.vue";
import ListColumn from "@/Pages/Category/Partials/ListColumn.vue";
import Topic from "@/Pages/Category/Topics/Partials/Topic.vue";
import ListPlaceholder from "@/Pages/Category/Partials/ListPlaceholder.vue";

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
      <PageHeading>
        {{ category.name }}
      </PageHeading>
    </PageHeader>

    <NavigationTabs
      :category="category"
      current-tab="topics"
    />

    <Search
      :value="search"
      @search="searchTopics"
    />

    <div
      v-if="topics.items.length > 0"
      class="mt-4 space-y-4"
    >
      <List>
        <ListColumns>
          <ListColumn
            class="flex-1"
            title="Title"
            sortable
            :order="order"
            :active="sort === 'name'"
            @sort="sortOrder => sortList('name', sortOrder)"
          />

          <ListColumn
            class="min-w-[7rem] justify-end"
            title="articles"
            sortable
            :order="order"
            :active="sort === 'articles_count'"
            @sort="sortOrder => sortList('articles_count', sortOrder)"
          />

          <ListColumn
            class="min-w-[7rem] justify-end"
            title="Subscribers"
            sortable
            :order="order"
            :active="sort === 'subscribers_count'"
            @sort="sortOrder => sortList( 'subscribers_count', sortOrder)"
          />
        </ListColumns>

        <Topic
          class="mt-5"
          v-for="topic in topics.items"
          :key="topic.id"
          :topic="topic"
        />
      </List>

      <Pagination :items="topics"/>
    </div>

    <ListPlaceholder v-else class="mt-24">
      <div class="text-sm text-gray-400 font-medium space-x-1">
        <span>{{ $trans('Unfortunately no topics found') }}.</span>

        <!-- TODO: add feedback link -->
        <Link
          class="text-sky-600/75"
          href="#"
        >
          {{ $trans('Suggest a new topic') }}?
        </Link>
      </div>
    </ListPlaceholder>
  </MainLayout>
</template>
