<script setup>
import {Head} from "@inertiajs/vue3";
import PageLayout from "@/Pages/User/Partials/PageLayout.vue";
import TopicsList from "@/Pages/User/Profile/Partials/TopicsList.vue";
import UserInformation from "@/Pages/User/Profile/Partials/UserInformation.vue";
import UserContacts from "@/Pages/User/Profile/Partials/UserContacts.vue";

defineProps({
  user: {
    type: Object,
    required: true,
  },

  topics: {
    type: Array,
    required: true,
  },

  contacts: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <PageLayout
    current-tab="profile"
    :user="user"
  >
    <Head :title="$ucfirst($trans('profile'))"/>

    <div class="mt-4 p-4 bg-white">
      <UserInformation
        class="mb-4 block lg:hidden"
        :user="user"
      />

      <UserContacts
        class="mb-4"
        v-if="contacts.length > 0"
        :contacts="contacts"
      />

      <TopicsList :topics="topics"/>
    </div>
  </PageLayout>
</template>
