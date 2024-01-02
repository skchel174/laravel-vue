<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination/Pagination.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import NavigationWrapper from "@/Pages/User/Partials/NavigationWrapper.vue";
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

const currentLink = ref('comments');

const navigation = {
  articles: route('user.bookmarks.articles', {user: props.user.login}),
  comments: route('user.bookmarks.comments', {user: props.user.login}),
};

const selectLink = (value) => {
  router.get(navigation[value]);
};
</script>

<template>
  <UserLayout
    current-tab="bookmarks"
    :user="user"
  >
    <NavigationWrapper
      :navigation="Object.keys(navigation)"
      :current-link="currentLink"
      @select="selectLink"
    >
      <div
        class="space-y-4"
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
          route-name="user.articles"
          :queryParams="{user: user.login}"
        />
      </div>

      <div v-else class="mt-16 w-full flex flex-col items-center space-y-8 text-base text-gray-400 font-bold">
        Unfortunately there are no comments here yet
      </div>
    </NavigationWrapper>
  </UserLayout>
</template>
