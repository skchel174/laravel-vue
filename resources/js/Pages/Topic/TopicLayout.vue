<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import SuccessOutlineButton from "@/Components/Buttons/SuccessOutlineButton.vue";
import SuccessButton from "@/Components/Buttons/SuccessButton.vue";
import Tabs from "@/Components/Tabs/Tabs.vue";
import Tab from "@/Components/Tabs/Tab.vue";

const props = defineProps({
  topic: {
    type: Object,
    required: true,
  },

  subscription: {
    type: Boolean,
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
  <MainLayout>
    <header class="bg-white p-4 pb-8 space-y-4">
      <div class="flex justify-between">
        <div class="flex items-center space-x-6">
          <img
            class="h-12 w-12"
            :src="topic.icon"
            :alt="topic.slug"
          >

          <div class="flex space-x-4">
            <div class="flex flex-col items-center">
              <p class="text-base text-pink-600/75 font-semibold">
                {{ $formatCount(topic.articles_count) }}
              </p>

              <p class="text-xs text-gray-400 capitalize">
                {{ $trans('articles') }}
              </p>
            </div>

            <div class="flex flex-col items-center">
              <p class="text-base text-gray-700 font-semibold">
                {{ $formatCount(topic.subscribers_count) }}
              </p>

              <p class="text-xs text-gray-400 capitalize">
                {{ $trans('subscribers') }}
              </p>
            </div>
          </div>
        </div>

        <div v-if="$page.props.auth.user">
          <SuccessButton v-if="subscription" class="!px-8">
            {{ $trans('Subscribed') }}
          </SuccessButton>

          <SuccessOutlineButton v-else class="!px-8">
            {{ $trans('Subscribe') }}
          </SuccessOutlineButton>
        </div>
      </div>

      <div class="space-y-1">
        <h1 class="text-xl text-gray-800 font-semibold">
          {{ topic.name }}
        </h1>

        <p class="text-sm text-gray-700">
          {{ topic.description }}
        </p>
      </div>
    </header>

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

    <slot/>
  </MainLayout>
</template>
