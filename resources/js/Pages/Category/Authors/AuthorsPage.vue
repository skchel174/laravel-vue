<script setup>
import {router} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import PageHeader from "@/Pages/Category/Partials/PageHeader.vue";
import NavigationTabs from "@/Pages/Category/Partials/NavigationTabs.vue";
import Search from "@/Pages/Category/Partials/Search.vue";
import List from "@/Pages/Category/Partials/List.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import ListColumn from "@/Pages/Category/Partials/ListColumn.vue";
import ListColumns from "@/Pages/Category/Partials/ListColumns.vue";
import PageHeading from "@/Pages/Category/Partials/PageHeading.vue";
import Author from "@/Pages/Category/Authors/Partials/Author.vue";
import ListPlaceholder from "@/Pages/Category/Partials/ListPlaceholder.vue";

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
    <PageHeader>
      <PageHeading>
        {{ category.name }}
      </PageHeading>
    </PageHeader>

    <NavigationTabs
      :category="category"
      current-tab="authors"
    />

    <Search
      :value="search"
      @search="searchTopics"
    />

    <div
      v-if="authors.items.length > 0"
      class="mt-4 space-y-4"
    >
      <List>
        <ListColumns>
          <ListColumn
            class="flex-1"
            title="Name"
          />

          <ListColumn
            class="max-w-10"
            title="Contribution to topics"
            active
          />
        </ListColumns>

        <Author
          class="mt-4"
          v-for="author in authors.items"
          :key="author.id"
          :author="author"
        />
      </List>

      <Pagination
        v-if="authors.totalPages > 1"
        :total-pages="authors.totalPages"
        :current-page="authors.currentPage"
        route-name="category.authors"
        :query-params="{...authors.query, category: category.slug}"
      />
    </div>

    <ListPlaceholder v-else class="mt-24">
      <p class="text-sm text-gray-400 font-medium">
        {{ $trans('empty_request_result') }}
      </p>
    </ListPlaceholder>
  </MainLayout>
</template>
