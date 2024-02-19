<script setup>
import {Head} from "@inertiajs/vue3";
import PageLayout from "@/Pages/User/Partials/PageLayout.vue";
import FollowingsList from "@/Components/Followings/FollowingsList.vue";

const props = defineProps({
  users: {
    type: Object,
    required: true,
  },

  user: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <PageLayout
    :user="user"
    current-tab="following"
  >
    <Head :title="$ucfirst($trans('following'))"/>

    <FollowingsList
      class="mt-4"
      :users="users"
    />
  </PageLayout>
</template>
