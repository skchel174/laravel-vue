<script setup>
import CabinetLayout from "@/Layouts/Cabinet/CabinetLayout.vue";
import ProfileInfo from "@/Pages/Cabinet/Profile/Partials/ProfileInfo.vue";
import ProfileTopics from "@/Pages/Cabinet/Profile/Partials/ProfileTopics.vue";

defineProps({
  topics: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <CabinetLayout current-tab="profile">
    <div class="mt-4 p-4 bg-white">
      <ProfileInfo
        class="mb-4 block lg:hidden"
        :user="$page.props.auth.user"
      />

      <ProfileTopics :topics="topics"/>
    </div>
  </CabinetLayout>
</template>
