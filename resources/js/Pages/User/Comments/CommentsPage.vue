<script setup>
import {Head} from "@inertiajs/vue3";
import CommentsList from "@/Components/Comment/CommentsList.vue";
import PageLayout from "@/Pages/User/Partials/PageLayout.vue";

const props = defineProps({
  comments: {
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
    current-tab="comments"
    :user="user"
  >
    <Head :title="$ucfirst($trans('comments'))"/>

    <CommentsList
      class="mt-4"
      :comments="comments"
    />
  </PageLayout>
</template>
