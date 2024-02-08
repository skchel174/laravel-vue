<script setup>
import {ref} from "vue";
import Tabs from "@/Components/Tabs/Tabs.vue";
import Tab from "@/Components/Tabs/Tab.vue";

const props = defineProps({
  heading: {

  },

  currentTab: {
    type: String,
    required: true,
  },

  tabs: {
    type: Object,
    required: true,
  },
});

const currentTab = ref(props.currentTab);

const selectTab = (tab) => {
  currentTab.value = tab;
};
</script>

<template>
  <nav>
    <Tabs>
      <Tab
        v-for="(_, tab) in tabs"
        :key="tab"
        :selected="tab === currentTab"
        @click="selectTab(tab)"
      >
        {{ $trans(tab) }}
      </Tab>
    </Tabs>
  </nav>
</template>
