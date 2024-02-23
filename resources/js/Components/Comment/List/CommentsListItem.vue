<script setup>
import {Link} from "@inertiajs/vue3";
import useBookmark from "@/Hooks/useBookmark.js";
import Divider from "@/Components/Divider.vue";
import CommentAuthor from "@/Components/Comment/CommentAuthor.vue";
import BookmarkIcon from "@/Components/Icons/BookmarkIcon.vue";

const props = defineProps({
  comment: {
    type: Object,
    required: true,
  },
});

const {
  loading,
  isBookmarked,
  toggleBookmark,
} = useBookmark(props.comment.isBookmarked);

const onBookmarked = () => {
  toggleBookmark(route('api.comments.bookmark', {
    article: props.comment.article_id,
    comment: props.comment.id,
  }));
};
</script>

<template>
  <div class="p-4 bg-white">
    <Link
      class="mb-6 text-lg font-bold hover:text-sky-600 transition duration-300"
      :href="route('article', {article: comment.article_id})"
    >
      {{ comment.article_title }}
    </Link>

    <Divider class="mt-3 mb-4"/>

    <CommentAuthor
      class="mb-2"
      :author="comment.author"
      :created-date="comment.created_date"
    />

    <div class="mb-4 text-sm font-medium text-gray-700">
      {{ comment.text }}
    </div>

    <footer class="flex items-center space-x-4">
      <BookmarkIcon
        :loading="loading"
        :is-bookmarked="isBookmarked"
        @toggle="onBookmarked"
      />

      <Link
        class="text-sm text-gray-400 cursor-pointer"
        :href="`${route('article.comments', {article: comment.article_id})}#comment_${comment.id}`"
      >
        {{ $trans('Look') }}
      </Link>
    </footer>
  </div>
</template>
