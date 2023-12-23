<script setup>
import {inject} from "vue";
import {usePage} from "@inertiajs/vue3";
import useLike from "@/Hooks/useLike.js";
import useBookmark from "@/Hooks/useBookmark.js";
import LikesIcon from "@/Components/Icons/LikesIcon.vue";
import BookmarkIcon from "@/Components/Icons/BookmarkIcon.vue";

const props = defineProps({
  articleId: {
    type: Number,
    required: true,
  },

  commentId: {
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
});

const user = usePage().props.auth.user;

const notify = inject('notify');

const {isLiked, likesCount, toggleLike} = useLike(props.isLiked, props.likesCount);

const onLike = () => {
  if (!user) {
    notify('error', 'Login to like comments');
  }
};

const {isBookmarked, toggleBookmark} = useBookmark(props.isBookmarked);

const onBookmarked = () => {
  if (!user) {
    notify('error', 'Login to bookmark comments');
  }
};

const copyLink = () => {
  const link = route('article', {id: props.articleId}) + `#comment_${props.commentId}`;
  navigator.clipboard.writeText(link);
  notify('success', 'Link was copied');
};
</script>

<template>
  <div class="w-full flex items-center justify-between sm:justify-start sm:space-x-4 text-gray-400">
    <LikesIcon
      :is-liked="isLiked"
      :count="likesCount"
      @toggle="onLike"
    />

    <span class="text-sm text-gray-400 cursor-pointer hover:text-gray-500 transition duration-200 select-none">
      Reply
    </span>

    <BookmarkIcon
      :is-bookmarked="isBookmarked"
      @toggle="onBookmarked"
    />

    <span
      class="material-icons text-gray-300 !text-2xl hover:text-gray-400 active:scale-[0.95] cursor-pointer transition duration-200 select-none"
      @click="copyLink"
    >
      link
    </span>
  </div>
</template>
