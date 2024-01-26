<script setup>
import {usePage} from "@inertiajs/vue3";
import {inject, onMounted, ref} from "vue";
import useBookmark from "@/Hooks/useBookmark.js";
import CommentAuthor from "@/Components/Comment/CommentAuthor.vue";
import CommentReplyForm from "@/Components/Comment/CommentReplyForm.vue";
import CommentEditForm from "@/Components/Comment/CommentEditForm.vue";
import CommentText from "@/Components/Comment/CommentText.vue";
import CommentFooter from "@/Components/Comment/CommentFooter.vue";
import BookmarkIcon from "@/Components/Icons/BookmarkIcon.vue";
import CopyLinkIcon from "@/Components/Icons/CopyLinkIcon.vue";
import CommentEditButton from "@/Components/Comment/CommentEditButton.vue";
import OpenThreadButton from "@/Components/Comment/OpenThreadButton.vue";
import ToggleThreadButton from "@/Components/Comment/ToggleThreadButton.vue";

const props = defineProps({
  comment: {
    type: Object,
    required: true,
  },

  bookmarkedIds: {
    type: Array,
    required: true,
  },

  articleId: {
    type: Number,
    required: true,
  },

  depth: {
    type: Number,
    default: 0,
  },
});

const page = usePage();
const user = page.props.auth.user;

const notify = inject('notify');

const copyLink = () => {
  const link = route('article', {article: props.articleId});
  navigator.clipboard.writeText(`${link}#comment_${props.comment.id}`);
  /* TODO: add localization */
  notify('success', 'Link was copied');
};

const {isBookmarked, toggleBookmark} = useBookmark();

const onBookmarked = () => {
  const url = route('api.comments.bookmark', {
    article: props.articleId,
    comment: props.comment.id,
  });

  toggleBookmark(url)
    /* TODO: add localization */
    .then(() => notify('success', 'Comment added to bookmarks'))
    .catch(error => notify('error', error.message))
};

onMounted(() => {
  isBookmarked.value = props.bookmarkedIds.includes(props.comment.id);
});

const {commentable, setCommentable} = inject('commentable');

const isOpen = ref(true);

const toggleVisibility = () => {
  isOpen.value = !isOpen.value;

  if (!isOpen.value) {
    setCommentable(null);
  }
};
</script>

<template>
  <div :id="`comment_${comment.id}`">
    <div class="pt-4 pb-2 flex items-stretch">
      <ToggleThreadButton
        :open="isOpen"
        :depth="depth"
        @click="toggleVisibility"
      />

      <OpenThreadButton
        v-show="!isOpen"
        @click="toggleVisibility"
        :comments-count="comment.total_comments + 1"
      />

      <div
        class="w-full pr-4"
        v-show="isOpen"
      >
        <div class="flex items-center space-x-4">
          <CommentAuthor
            class="mb-1"
            :author="comment.author"
            :created-date="comment.created_date"
          />

          <CommentEditButton
            v-if="user?.id === comment.author.id && comment.is_editable"
            @click="() => setCommentable(`comment_${props.comment.id}_edit`)"
          />
        </div>

        <CommentText>
          {{ comment.text }}
        </CommentText>

        <CommentFooter class="mt-2">
          <BookmarkIcon
            :is-bookmarked="isBookmarked"
            @toggle="onBookmarked"
          />

          <button
            class="text-sm text-gray-400 cursor-pointer hover:text-gray-500 transition duration-200 select-none"
            v-if="user"
            @click="() => setCommentable(`comment_${props.comment.id}`)"
          >
            Reply
          </button>

          <CopyLinkIcon @click="copyLink"/>
        </CommentFooter>
      </div>
    </div>

    <CommentReplyForm
      v-if="commentable === `comment_${comment.id}`"
      :article-id="articleId"
      :comment-id="comment.id"
      :author="comment.author.login"
      @close="() => setCommentable(null)"
    />

    <CommentEditForm
      v-if="commentable === `comment_${comment.id}_edit`"
      :text="comment.text"
      :article-id="articleId"
      :comment-id="comment.id"
      @close="() => setCommentable(null)"
    />

    <div v-show="isOpen">
      <Comment
        v-for="comment in comment.comments"
        :key="comment.id"
        :comment="comment"
        :bookmarked-ids="bookmarkedIds"
        :article-id="articleId"
        :depth="depth + 1"
      />
    </div>
  </div>
</template>
