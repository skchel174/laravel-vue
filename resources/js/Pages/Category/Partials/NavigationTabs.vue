<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import Tabs from "@/Components/Tabs/Tabs.vue";
import Tab from "@/Components/Tabs/Tab.vue";

const props = defineProps({
  category: {
    type: Object,
    required: true,
  },

  currentTab: {
    type: String,
    required: true,
  },
});

const currentTab = ref(props.currentTab);

const navigationTabs = {
  articles: 'category.articles',
  topics: 'category.topics',
  authors: 'category.authors',
};

const selectTab = (tab) => {
  currentTab.value = tab;
  router.get(route(navigationTabs[tab], {category: props.category.slug}))
};
</script>

<template>
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
</template>
