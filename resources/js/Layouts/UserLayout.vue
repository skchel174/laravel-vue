<script setup>
import {ref} from "vue";
import {Link, router} from "@inertiajs/vue3";
import Tab from "@/Components/Tabs/Tab.vue";
import Tabs from "@/Components/Tabs/Tabs.vue";
import Avatar from "@/Components/Avatar.vue";
import Divider from "@/Components/Divider.vue";
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import MainWrapper from "@/Components/MainWrapper.vue";
import NotificationWrapper from "@/Components/NotificationWrapper.vue";

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
  profile: route('user', {user: props.user.login}),
  articles: route('user.articles', {user: props.user.login}),
  comments: route('user.comments', {user: props.user.login}),
  bookmarks: route('user.bookmarks.articles', {user: props.user.login}),
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

    <MainWrapper>
      <div
        class="w-full flex flex-col items-center lg:items-start lg:flex-row lg:justify-between space-y-4 lg:space-y-0 lg:space-x-4">
        <div class="flex-1 w-full max-w-3xl">
          <div class="relative z-10 bg-white">
            <div class="p-4">
              <Avatar
                size="md"
                :value="user.avatar"
                clickable
              />

              <h3 class="mt-2 text-base sm:text-lg">
                <span
                  class="text-gray-800 font-black"
                  v-if="user.name"
                >
                  {{ user.name }}
                </span>

                <Link
                  class="text-sky-600"
                  :href="route('user', {user: user.login})"
                >
                  @{{ user.login }}
                </Link>
              </h3>

              <p class="mt-1 text-sm text-gray-500 font-medium capitalize">
                user
              </p>
            </div>

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

        <div class="hidden lg:block w-80 space-y-4">
          <div class="p-4 bg-white w-full lg:max-w-xs">
            <h2 class="text-sm text-gray-500 font-bold uppercase">
              Information
            </h2>

            <Divider class="my-4"/>

            <table class="w-full max-w-xs">
              <tr>
                <td class="pb-1 text-sm text-gray-700 font-bold">
                  Registered
                </td>
                <td class="pb-1 px-4 text-xs text-gray-700 font-medium">
                  {{ user.created_at }}
                </td>
              </tr>
              <tr>
                <td class="pt-2 text-sm text-gray-700 font-bold">
                  Activity
                </td>
                <td class="pt-2 px-4 text-xs text-gray-700 font-medium">
                  {{ $formatDate(user.login_at, 'DD MMM YYYY') }}
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </MainWrapper>
  </NotificationWrapper>
</template>
