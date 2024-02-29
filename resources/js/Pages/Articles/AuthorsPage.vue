<script setup>
import {ref} from "vue";
import {router, Head} from "@inertiajs/vue3";
import MainLayout from "@/Components/Layouts/MainLayout.vue";
import AuthorsList from "@/Components/AuthorsList/AuthorsList.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";
import SearchInput from "@/Components/SearchInput.vue";
import Tabs from "@/Components/Tabs/Tabs.vue";
import Tab from "@/Components/Tabs/Tab.vue";

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

const currentTab = ref('authors');

const navigationTabs = {
  articles: route('articles'),
  topics: route('topics'),
  authors: route('authors'),
};

const selectTab = (tab) => {
  currentTab.value = tab;
  router.get(navigationTabs[tab]);
};

const searchAuthors = (search) => {
  router.get(route('authors', {search}));
};
</script>

<template>
  <MainLayout>
    <Head :title="$trans('Authors')"/>

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
