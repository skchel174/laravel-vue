<script setup>
import {inject} from "vue";
import useLike from "@/Hooks/useLike.js";
import {router, usePage} from "@inertiajs/vue3";
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

const user = usePage().props.auth.user;

const notify = inject('notify');

const {isLiked, likesCount, toggleLike} = useLike(props.isLiked, props.likesCount);

const onLike = () => {
  if (!user) {
    // TODO: move to hook
    notify('error', 'Login to like this article');
    return;
  }

  toggleLike(route('api.articles.like', {
    article: props.articleId,
  }));
};

const {isBookmarked, toggleBookmark} = useBookmark(props.isBookmarked);

const onBookmarked = () => {
  toggleBookmark(route('api.articles.bookmark', {article: props.articleId}))
    .then(() => notify('success', 'Article added to bookmarks'))
    .catch(error => notify('error', error.message))
};
</script>

<template>
  <div class="w-full flex justify-between sm:justify-start sm:space-x-8 text-gray-400">
    <LikesIcon
      :is-liked="isLiked"
      :count="likesCount"
      @toggle="onLike"
    />

    <CommentsIcon
      :count="commentsCount"
      @click="() => router.get(route('article.comments', {article: articleId}))"
    />

    <BookmarkIcon
      :is-bookmarked="isBookmarked"
      @toggle="onBookmarked"
    />

    <ShareIcon/>
  </div>
</template>
