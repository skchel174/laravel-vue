<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import Tab from "@/Components/Tabs/Tab.vue";
import Tabs from "@/Components/Tabs/Tabs.vue";
import Divider from "@/Components/Divider.vue";
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import UserInfo from "@/Layouts/User/Partials/UserInfo.vue";
import UserCard from "@/Layouts/User/Partials/UserCard.vue";
import NotificationWrapper from "@/Layouts/NotificationWrapper.vue";

const props = defineProps({
  currentTab: {
    type: String,
    required: true,
  },

  user: {
    type: Object,
    required: true,
  },
});

const tabs = {
  profile: route('user', {
    user: props.user.id,
  }),

  articles: route('user.articles', {
    user: props.user.id,
  }),

  bookmarks: route('user.bookmarks.articles', {
    user: props.user.id,
  }),
};

const currentTab = ref(props.currentTab);

const selectTab = (tab) => {
  currentTab.value = tab;
  router.get(tabs[tab]);
};
</script>

<template>
  <NotificationWrapper>
    <AppHeader/>

    <main class="sm:px-2 mx-auto w-full max-w-3xl lg:max-w-5xl flex flex-col">
      <div class="hidden lg:block h-4"/>

      <div
        class="w-full flex flex-col items-center lg:items-start lg:flex-row lg:justify-between space-y-4 lg:space-y-0 lg:space-x-4">
        <div class="flex-1 w-full max-w-3xl">
          <div class="relative z-10 bg-white">
            <UserCard
              class="p-4"
              :user="user"
            />

            <Tabs v-if="tabs">
              <Tab
                v-for="(_, tab) in tabs"
                :key="tab"
                :selected="currentTab === tab"
                @click="() => selectTab(tab)"
              >
                {{ tab }}
              </Tab>
            </Tabs>
          </div>

          <slot/>
        </div>

        <div class="hidden lg:block p-4 bg-white w-full lg:max-w-xs">
          <h2 class="text-sm text-gray-500 font-bold uppercase">
            Information
          </h2>

          <Divider class="my-4"/>

          <UserInfo :user="user"/>
        </div>
      </div>
    </main>
  </NotificationWrapper>
</template>
