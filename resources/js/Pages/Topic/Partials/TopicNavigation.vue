<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import Tab from "@/Components/Tabs/Tab.vue";
import Tabs from "@/Components/Tabs/Tabs.vue";

const props = defineProps({
  topic: {
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
  articles: 'topic.articles',
  authors: 'topic.authors',
};

const selectTab = (tab) => {
  currentTab.value = tab;

  router.get(route(navigationTabs[tab], {topic: props.topic.slug}))
};
</script>

<template>
  <nav>
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
  </nav>
</template>
