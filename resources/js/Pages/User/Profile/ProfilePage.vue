<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import ProfileInfo from "@/Pages/User/Profile/Partials/ProfileInfo.vue";
import ProfileTopics from "@/Pages/User/Profile/Partials/ProfileTopics.vue";

defineProps({
  user: {
    type: Object,
    required: true,
  },

  topics: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <UserLayout
    current-tab="profile"
    :user="user"
  >
    <div class="mt-4 p-4 bg-white space-y-4">
      <ProfileInfo
        class="mb-4 block lg:hidden"
        :user="user"
      />

      <ProfileTopics
        :topics="topics"
        :user="user"
        :auth="$page.props.auth"
      />
    </div>
  </UserLayout>
</template>
