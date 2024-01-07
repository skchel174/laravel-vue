<script setup>
import {usePage} from "@inertiajs/vue3";
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import MainWrapper from "@/Components/MainWrapper.vue";
import NotificationWrapper from "@/Components/NotificationWrapper.vue";
import ProfileWidget from "@/Components/ProfileWidget.vue";
import NavigationTabs from "@/Pages/User/Partials/NavigationTabs.vue";
import TopicsContribution from "@/Layouts/User/Partials/TopicsContribution.vue";
import SidebarSection from "@/Layouts/User/Partials/SidebarSection.vue";
import UserInformation from "@/Layouts/User/Partials/UserInformation.vue";

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

const contribution = usePage().props.contribution;
</script>

<template>
  <NotificationWrapper>
    <AppHeader/>

    <MainWrapper>
      <div
        class="w-full flex flex-col items-center lg:items-start lg:flex-row lg:justify-between space-y-4 lg:space-y-0 lg:space-x-4">
        <div class="flex-1 w-full max-w-3xl">
          <div class="relative z-10 bg-white">
            <ProfileWidget
              :user="user"
              :subscription="$page.props.subscription"
            />

            <NavigationTabs
              :user="user"
              :current-tab="currentTab"
            />
          </div>

          <slot/>
        </div>

        <div class="hidden lg:block w-80 space-y-4">
          <SidebarSection title="Information">
            <UserInformation :user="user"/>
          </SidebarSection>

          <SidebarSection
            v-if="contribution.length > 0"
            title="Contribution to topics"
          >
            <TopicsContribution :topics="contribution"/>
          </SidebarSection>
        </div>
      </div>
    </MainWrapper>
  </NotificationWrapper>
</template>
