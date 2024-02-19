<script setup>
import ProfileWidget from "@/Components/ProfileWidget.vue";
import NavigationTabs from "@/Pages/User/Partials/NavigationTabs.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import UserInformation from "@/Pages/User/Partials/UserInformation.vue";
import UserContribution from "@/Pages/User/Partials/UserContribution.vue";

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
</script>

<template>
  <MainLayout>
    <ProfileWidget
      :user="user"
      :subscription="$page.props.subscription"
    />

    <NavigationTabs
      :user="user"
      :current-tab="currentTab"
    />

    <slot/>

    <template v-slot:sidebar>
      <div class="space-y-4">
        <UserInformation :user="user"/>
        <UserContribution :contribution="$page.props.contribution"/>
      </div>
    </template>
  </MainLayout>
</template>
