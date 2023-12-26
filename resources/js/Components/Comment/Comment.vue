<script setup>
import {usePage} from "@inertiajs/vue3";
import {inject, onMounted, ref} from "vue";
import useBookmark from "@/Hooks/useBookmark.js";
import CommentReaction from "@/Components/Comment/CommentReaction.vue";
import CommentAuthor from "@/Components/Comment/CommentAuthor.vue";
import HideButton from "@/Components/Comment/HideButton.vue";
import CommentReplyForm from "@/Components/Comment/CommentReplyForm.vue";
import CommentEditForm from "@/Components/Comment/CommentEditForm.vue";

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

const user = usePage().props.auth.user;

const notify = inject('notify');

const copyLink = () => {
  const link = route('article', {article: props.articleId});
  navigator.clipboard.writeText(`${link}#comment_${props.comment.id}`);
  notify('success', 'Link was copied');
};

const {isBookmarked, toggleBookmark} = useBookmark();

const onBookmarked = () => {
  const url = route('api.comments.bookmark', {
    article: props.articleId,
    comment: props.comment.id,
  });

  toggleBookmark(url)
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
    closeForm();
  }
};

const openForm = (commentId) => {
  setCommentable(commentId);
};

const closeForm = () => {
  setCommentable(null);
};
</script>

<template>
  <div :id="`comment_${comment.id}`">
    <div class="pt-4 pb-2 flex items-stretch">
      <HideButton
        :open="isOpen"
        :depth="depth"
        @click="toggleVisibility"
      />

      <div
        class="inline-flex items-center pt-[0.175rem] cursor-pointer"
        v-show="!isOpen"
        @click="toggleVisibility"
      >
        <p class="text-sky-600 text-base font-bold">
          Show comments ({{ comment.total_comments + 1 }})
        </p>
      </div>

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

          <div
            v-if="comment.author.id === user?.id && comment.is_editable"
            class="flex items-center space-x-1 cursor-pointer text-sky-600 hover:text-sky-700 transition duration-200"
            @click="() => openForm(`comment_${props.comment.id}_edit`)"
          >
            <span class="material-icons !text-xs !leading-none">
              edit
            </span>
            <span class="text-xs font-semibold !leading-none">
              Edit
            </span>
          </div>
        </div>

        <div class="text-sm font-medium text-gray-700">
          {{ comment.text }}
        </div>

        <CommentReaction
          class="mt-2"
          :bookmarked-ids="bookmarkedIds"
          :is-bookmarked="isBookmarked"
          :comments-count="comment.total_comments"
          @bookmarked="onBookmarked"
          @copy="copyLink"
          @reply="() => openForm(`comment_${props.comment.id}`)"
        />
      </div>
    </div>

    <CommentReplyForm
      v-if="commentable === `comment_${comment.id}`"
      :article-id="articleId"
      :comment-id="comment.id"
      :author="comment.author.login"
      @close="closeForm"
    />

    <CommentEditForm
      v-if="commentable === `comment_${comment.id}_edit`"
      :text="comment.text"
      :article-id="articleId"
      :comment-id="comment.id"
      @close="closeForm"
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
