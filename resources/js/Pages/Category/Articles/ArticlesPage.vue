<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import Tabs from "@/Components/Tabs/Tabs.vue";
import Tab from "@/Components/Tabs/Tab.vue";
import ArticlesFilters from "@/Components/ArticleFeed/ArticlesFilters.vue";
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import Placeholder from "@/Components/ArticleFeed/Placeholder.vue";

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

const currentTab = ref('articles');

const navigationTabs = {
  articles: route('category.articles', {category: props.category.slug}),
  topics: '#',
  authors: '#',
};
</script>

<template>
  <MainLayout>
    <header class="w-full p-4 sm:px-6 bg-white">
      <h1 class="text-xl text-gray-700 font-semibold">
        {{ category.name }}
      </h1>
    </header>

    <nav>
      <Tabs>
        <Tab
          v-for="(_, tab) in navigationTabs"
          :key="tab"
          :selected="tab === currentTab"
          @click="currentTab = tab"
        >
          {{ $trans(tab) }}
        </Tab>
      </Tabs>
    </nav>

    <ArticlesFilters
      @apply="filters => router.get(route('articles', filters))"
    />

    <div
      class="mt-4 space-y-4"
      v-if="articles.items.length > 0"
    >
      <ArticleCard
        v-for="article in articles.items"
        :key="article.id"
        :article="article"
      />

      <Pagination
        v-if="articles.totalPages > 1"
        :query-params="articles.query"
        :total-pages="articles.totalPages"
        :current-page="articles.currentPage"
        route-name="articles"
      />
    </div>

    <Placeholder v-else class="mt-24"/>
  </MainLayout>
</template>
