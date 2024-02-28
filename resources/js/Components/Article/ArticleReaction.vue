<script setup>
import {router} from "@inertiajs/vue3";
import useBookmark from "@/Hooks/useBookmark.js";
import CommentsIcon from "@/Components/Icons/CommentsIcon.vue";
import BookmarkIcon from "@/Components/Icons/BookmarkIcon.vue";
import ShareIcon from "@/Components/Icons/ShareIcon.vue";

const props = defineProps({
  articleId: {
    type: Number,
    required: true,
  },

  isBookmarked: {
    type: Boolean,
    required: true,
  },

  commentsCount: {
    type: Number,
    required: true,
  },
});

const {
  isBookmarked,
  loading: bookmarkLoading,
  toggleBookmark,
} = useBookmark(props.isBookmarked);
</script>

<template>
  <div class="w-full flex justify-between sm:justify-start sm:space-x-8 text-gray-400">
    <BookmarkIcon
      :loading="bookmarkLoading"
      :is-bookmarked="isBookmarked"
      @toggle="toggleBookmark(route('api.articles.bookmark', {article: articleId}))"
    />

    <ShareIcon/>

    <CommentsIcon
      :count="commentsCount"
      @click="router.get(route('article.comments', {article: articleId}))"
    />
  </div>
</template>
