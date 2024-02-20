<script setup>
import {router} from "@inertiajs/vue3";
import useLike from "@/Hooks/useLike.js";
import useBookmark from "@/Hooks/useBookmark.js";
import LikesIcon from "@/Components/Icons/LikesIcon.vue";
import CommentsIcon from "@/Components/Icons/CommentsIcon.vue";
import BookmarkIcon from "@/Components/Icons/BookmarkIcon.vue";
import ShareIcon from "@/Components/Icons/ShareIcon.vue";

const props = defineProps({
  articleId: {
    type: Number,
    required: true,
  },

  isLiked: {
    type: Boolean,
    required: true,
  },

  likesCount: {
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
  isLiked,
  likesCount,
  loading: likeLoading,
  toggleLike,
} = useLike(props.isLiked, props.likesCount);

const {
  isBookmarked,
  loading: bookmarkLoading,
  toggleBookmark,
} = useBookmark(props.isBookmarked);
</script>

<template>
  <div class="w-full flex justify-between sm:justify-start sm:space-x-8 text-gray-400">
    <LikesIcon
      :loading="likeLoading"
      :is-liked="isLiked"
      :count="likesCount"
      @toggle="toggleLike(route('api.articles.like', {article: articleId}))"
    />

    <CommentsIcon
      :count="commentsCount"
      @click="router.get(route('article.comments', {article: articleId}))"
    />

    <BookmarkIcon
      :loading="bookmarkLoading"
      :is-bookmarked="isBookmarked"
      @toggle="toggleBookmark(route('api.articles.bookmark', {article: articleId}))"
    />

    <ShareIcon/>
  </div>
</template>
