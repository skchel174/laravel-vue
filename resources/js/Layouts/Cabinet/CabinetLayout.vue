<script setup>
import {ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import Tab from "@/Components/Tabs/Tab.vue";
import Tabs from "@/Components/Tabs/Tabs.vue";
import Divider from "@/Components/Divider.vue";
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import ProfileInfo from "@/Layouts/Cabinet/Partials/ProfileInfo.vue";
import ProfileCard from "@/Layouts/Cabinet/Partials/ProfileCard.vue";

const user = usePage().props.auth.user;

const tabs = {
  profile: route('cabinet'),
  publications: route('cabinet'),
  bookmarks: route('cabinet'),
};

const currentTab = ref('profile');
</script>

<template>
  <AppHeader/>

  <main class="px-2 mx-auto w-full max-w-3xl lg:max-w-5xl h-full flex flex-col">
    <div class="hidden lg:block h-4"/>

    <div class="w-full flex flex-col items-center lg:items-start lg:flex-row lg:justify-between space-y-4 lg:space-y-0 lg:space-x-4">
      <div class="flex-1 w-full max-w-3xl">
        <div class="bg-white">
          <ProfileCard
            class="p-4"
            :user="user"
          />

          <Tabs v-if="tabs">
            <Tab
              v-for="(_, tab) in tabs"
              :key="tab"
              :selected="currentTab === tab"
              @click="currentTab = tab"
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

        <ProfileInfo :user="user"/>
      </div>
    </div>
  </main>
</template>
