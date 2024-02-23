<script setup>
import {inject, onMounted} from "vue";
import useBookmark from "@/Hooks/useBookmark.js";
import CommentReplyForm from "@/Components/Comment/Form/CommentReplyForm.vue";
import CommentEditForm from "@/Components/Comment/Form/CommentEditForm.vue";
import CommentAuthor from "@/Components/Comment/CommentAuthor.vue";
import BookmarkIcon from "@/Components/Icons/BookmarkIcon.vue";
import CopyLinkIcon from "@/Components/Icons/CopyLinkIcon.vue";
import ThreadContainer from "@/Components/Comment/ThreadContainer.vue";

const props = defineProps({
  comment: {
    type: Object,
    required: true,
  },

  depth: {
    type: Number,
    default: 0,
  },
});

const bookmarks = inject('bookmarks');

const {loading, isBookmarked, toggleBookmark} = useBookmark();

const handleBookmark = () => {
  toggleBookmark(route('api.comments.bookmark', {
    article: props.comment.article_id,
    comment: props.comment.id,
  }))
};

onMounted(() => {
  isBookmarked.value = bookmarks.includes(props.comment.id);
});

const notify = inject('notify');

const copyLink = () => {
  const url = route('article', {article: props.comment.article_id});
  navigator.clipboard.writeText(`${url}#comment_${props.comment.id}`);
  notify('success', 'Link was copied');
};

const {commentable, setCommentable} = inject('commentable');
</script>

<template>
  <ThreadContainer
    :id="`comment_${comment.id}`"
    :comments-count="comment.total_comments"
    :comments="comment.comments"
    :depth="depth"
  >
    <CommentAuthor
      class="mb-2"
      :author="comment.author"
      :created-date="comment.created_date"
    />

    <p class="mb-2 text-sm font-medium text-gray-700">
      {{ comment.text }}
    </p>

    <footer class="flex items-center space-x-4">
      <BookmarkIcon
        :loading="loading"
        :is-bookmarked="isBookmarked"
        @toggle="handleBookmark"
      />

      <button
        class="text-sm text-gray-400 cursor-pointer"
        v-if="$page.props.auth.user"
        @click="setCommentable(`comment_${comment.id}`)"
      >
        {{ $trans('Reply') }}
      </button>

      <CopyLinkIcon @click="copyLink"/>

      <button
        class="text-sm text-gray-400 cursor-pointer"
        v-if="$page.props.auth.user?.id === comment.author.id && comment.is_editable"
        @click="setCommentable(`comment_${comment.id}_edit`)"
      >
        {{ $trans('Edit') }}
      </button>
    </footer>

    <CommentReplyForm
      v-if="commentable === `comment_${comment.id}`"
      :comment-id="comment.id"
      :article-id="comment.article_id"
      :author="comment.author"
      @close="setCommentable(null)"
    />

    <CommentEditForm
      v-if="commentable === `comment_${comment.id}_edit`"
      :text="comment.text"
      :comment-id="comment.id"
      :article-id="comment.article_id"
      @close="setCommentable(null)"
    />
  </ThreadContainer>
</template>
