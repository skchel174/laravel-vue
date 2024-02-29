<script setup>
import {ref} from "vue";
import {Head, router} from "@inertiajs/vue3";
import MainLayout from "@/Components/Layouts/MainLayout.vue";
import Tabs from "@/Components/Tabs/Tabs.vue";
import Tab from "@/Components/Tabs/Tab.vue";
import SearchInput from "@/Components/SearchInput.vue";
import TopicsList from "@/Components/TopicsList/TopicsList.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";

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
    validator: (value) => ['asc', 'desc'].includes(value),
  },

  sort: {
    type: String,
    required: true,
    validator: (value) => ['name', 'articles_count', 'subscribers_count'].includes(value),
  },

  search: {
    type: [String, null],
    required: true,
  },
});

const currentTab = ref('topics');

// TODO: add pages for all tabs
const navigationTabs = {
  articles: route('articles'),
  topics: route('topics'),
  authors: '#',
};

const selectTab = (tab) => {
  currentTab.value = tab;
  router.get(navigationTabs[tab]);
};

const sortTopics = (sort, order) => {
  router.get(route('topics', {sort, order}));
};
</script>

<template>
  <MainLayout>
    <Head :title="$trans('Topics')"/>

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
