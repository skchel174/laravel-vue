<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import Tabs from "@/Components/Tabs/Tabs.vue";
import Tab from "@/Components/Tabs/Tab.vue";

const props = defineProps({
  currentTab: {
    type: String,
    required: true,
  },
});

const currentTab = ref(props.currentTab);

const navigationTabs = {
  profile: 'settings.profile',
  account: 'settings.account',
};

const selectTab = (tab) => {
  currentTab.value = tab;
  router.get(route(navigationTabs[tab]))
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
