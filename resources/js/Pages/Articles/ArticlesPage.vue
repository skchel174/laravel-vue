<script setup>
import {ref} from "vue";
import {router, Head} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import ArticlesFilters from "@/Components/Article/Filters/ArticlesFilters.vue";
import ArticlesList from "@/Components/Article/ArticlesList.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";
import Tabs from "@/Components/Tabs/Tabs.vue";
import Tab from "@/Components/Tabs/Tab.vue";

defineProps({
  articles: {
    type: Object,
    required: true,
  },
});

const currentTab = ref('articles');

// TODO: add pages for all tabs
const navigationTabs = {
  articles: route('articles'),
  topics: '#',
  authors: '#',
};

const selectTab = (tab) => {
  currentTab.value = tab;
};

const applyFilters = (filters) => {
  router.get(route('articles', filters));
};
</script>

<template>
  <MainLayout>
    <Head :title="$trans('Articles')"/>

    <header class="w-full p-4 bg-white">
      <h1 class="text-xl text-gray-700 font-semibold">
        {{ $trans('All categories') }}
      </h1>
    </header>

    <Tabs>
      <Tab
        v-for="(_, tab) in navigationTabs"
        :key="tab"
        :selected="tab === currentTab"
        @click="selectTab(tab)"
      >
        {{ $trans(tab) }}
      </Tab>
    </Tabs>

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
