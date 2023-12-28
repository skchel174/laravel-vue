<script setup>
import {inject} from "vue";
import {Link} from "@inertiajs/vue3";
import useBookmark from "@/Hooks/useBookmark.js";
import Divider from "@/Components/Divider.vue";
import CommentAuthor from "@/Components/Comment/CommentAuthor.vue";
import BookmarkIcon from "@/Components/Icons/BookmarkIcon.vue";
import CommentFooter from "@/Components/Comment/CommentFooter.vue";
import CommentText from "@/Components/Comment/CommentText.vue";

const props = defineProps({
  comment: {
    type: Object,
    required: true,
  },
});

const notify = inject('notify');

const {isBookmarked, toggleBookmark} = useBookmark(props.comment.is_bookmarked);

const onBookmarked = () => {
  const url = route('api.comments.bookmark', {
    article: props.comment.article_id,
    comment: props.comment.id,
  });

  toggleBookmark(url)
    .then(() => notify('success', 'Comment added to bookmarks'))
    .catch(error => notify('error', error.message))
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

    <CommentText class="mb-4">
      {{ comment.text }}
    </CommentText>

    <CommentFooter>
      <BookmarkIcon
        :is-bookmarked="isBookmarked"
        @toggle="onBookmarked"
      />

      <Link
        class="text-sm text-gray-400 cursor-pointer hover:text-gray-500 transition duration-200 select-none"
        :href="`${route('article', {article: comment.article_id})}#comment_${comment.id}`"
      >
        Look
      </Link>
    </CommentFooter>
  </div>
</template>
