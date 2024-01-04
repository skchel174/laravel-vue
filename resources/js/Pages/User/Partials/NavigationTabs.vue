<script setup>
import {computed, ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";
import useMedia from "@/Hooks/useMedia.js";
import Tabs from "@/Components/Tabs/Tabs.vue";
import Tab from "@/Components/Tabs/Tab.vue";
import Popover from "@/Components/Popover.vue";
import MenuList from "@/Components/Menu/MenuList.vue";
import MenuItem from "@/Components/Menu/MenuItem.vue";
import ExpandButton from "@/Components/Buttons/ExpandButton.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },

  currentTab: {
    type: String,
    required: true,
  },
});

const visibleTabs = {
  profile: 'user',
  articles: 'user.articles',
  comments: 'user.comments',
  bookmarks: 'user.bookmarks.articles',
};

const hiddenTabs = {
  following: 'user.following',
  followers: 'user.followers',
};

const isTablet = useMedia('(max-width: 1024px)');

const tabs = computed(() => {
  return isTablet.value ? {...visibleTabs, ...hiddenTabs} : visibleTabs;
});

const currentTab = ref(props.currentTab);

const selectTab = (tab) => {
  currentTab.value = tab;
  const routeName = visibleTabs[tab] || hiddenTabs[tab];
  router.get(route(routeName, {user: props.user.login}));
};

const indicators = usePage().props.indicators;

const isHiddenTabsOpen = ref(false);

const toggleHiddenTabs = () => {
  isHiddenTabsOpen.value = !isHiddenTabsOpen.value;
}
</script>

<template>
  <Tabs>
    <Tab
      v-for="(_, tab) in tabs"
      :key="tab"
      :selected="currentTab === tab"
      @click="() => selectTab(tab)"
    >
      <span>{{ tab }}</span>

      <span
        class="ml-1 text-sky-600"
        v-if="indicators[tab] && indicators[tab] > 0"
      >
        {{ $formatCount(indicators[tab]) }}
      </span>
    </Tab>

    <Tab
      class="relative"
      v-if="!isTablet"
      @click.stop="toggleHiddenTabs"
    >
      <ExpandButton
        class="uppercase"
        :expand="isHiddenTabsOpen"
      >
        More
      </ExpandButton>

      <Popover
        class="top-8 left-0 z-50"
        v-if="!isTablet"
        v-model:open="isHiddenTabsOpen"
      >
        <MenuList class="py-2">
          <MenuItem
            class="py-2 px-4 text-sm capitalize"
            v-for="(_, tab) in hiddenTabs"
            :key="tab"
            :selected="currentTab === tab"
            @click="() => selectTab(tab)"
          >
            <span>{{ tab }}</span>

            <span
              class="ml-2 text-sky-600"
              v-if="indicators[tab] && indicators[tab] > 0"
            >
              {{ $formatCount(indicators[tab]) }}
            </span>
          </MenuItem>
        </MenuList>
      </Popover>
    </Tab>
  </Tabs>
</template>
