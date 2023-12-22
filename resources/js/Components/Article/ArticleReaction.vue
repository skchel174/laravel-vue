<script setup>
import LikesIcon from "@/Components/Icons/LikesIcon.vue";
import CommentsIcon from "@/Components/Icons/CommentsIcon.vue";
import BookmarkIcon from "@/Components/Icons/BookmarkIcon.vue";
import ShareIcon from "@/Components/Icons/ShareIcon.vue";
import useLike from "@/Hooks/useLike.js";
import useBookmark from "@/Hooks/useBookmark.js";
import {usePage} from "@inertiajs/vue3";
import {inject} from "vue";

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
    notify('error', 'Login to like this article');
    return;
  }

  toggleLike(route('api.articles.like', {
    article: props.articleId,
  }));
};

const {isBookmarked, toggleBookmark} = useBookmark(props.isBookmarked);

const onBookmarked = () => {
  if (!user) {
    notify('error', 'Login to bookmark this article');
    return;
  }

  toggleBookmark(route('api.articles.bookmark', {
    article: props.articleId,
  }));
};
</script>

<template>
  <div class="w-full flex justify-between sm:justify-start sm:space-x-8 text-gray-400">
    <LikesIcon
      :is-liked="isLiked"
      :count="likesCount"
      @toggle="onLike"
    />

    <CommentsIcon :count="commentsCount"/>

    <BookmarkIcon
      :is-bookmarked="isBookmarked"
      @toggle="onBookmarked"
    />

    <ShareIcon/>
  </div>
</template>
