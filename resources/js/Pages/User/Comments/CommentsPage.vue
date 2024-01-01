<script setup>
import Pagination from "@/Components/Pagination/Pagination.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import CommentCard from "@/Components/Comment/CommentCard.vue";

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
  <UserLayout
    current-tab="comments"
    :user="user"
  >
    <div
      class="mt-4 space-y-4"
      v-if="comments.items.length > 0"
    >
      <CommentCard
        v-for="comment in comments.items"
        :key="comment.id"
        :comment="comment"
      />

      <Pagination
        v-if="comments.totalPages > 1"
        :query-params="comments.query"
        :total-pages="comments.totalPages"
        :current-page="comments.currentPage"
        route-name="user.comments"
        :queryParams="{user: user.login}"
      />
    </div>

    <div v-else class="mt-16 w-full flex flex-col items-center space-y-8 text-base text-gray-400 font-bold">
      Unfortunately there are no comments here yet
    </div>
  </UserLayout>
</template>
