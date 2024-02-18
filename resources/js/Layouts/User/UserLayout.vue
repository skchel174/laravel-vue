<script setup>
import {usePage} from "@inertiajs/vue3";
import ProfileWidget from "@/Components/ProfileWidget.vue";
import NavigationTabs from "@/Pages/User/Partials/NavigationTabs.vue";
import TopicsContribution from "@/Layouts/User/Partials/TopicsContribution.vue";
import SidebarSection from "@/Layouts/User/Partials/SidebarSection.vue";
import UserInformation from "@/Layouts/User/Partials/UserInformation.vue";
import MainLayout from "@/Layouts/MainLayout.vue";

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
  <MainLayout>
    <div class="flex-1 w-full">
      <div class="relative z-10 bg-white">
        <ProfileWidget
          :user="user"
          :subscription="$page.props.subscription"
        />

        <NavigationTabs
          class="mt-4"
          :user="user"
          :current-tab="currentTab"
        />
      </div>

      <slot/>
    </div>

    <template v-slot:sidebar>
      <div class="space-y-4">
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
    </template>
  </MainLayout>
</template>
