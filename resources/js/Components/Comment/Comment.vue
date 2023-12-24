<script setup>
import {ref} from "vue";
import CommentReaction from "@/Components/Comment/CommentReaction.vue";
import CommentAuthor from "@/Components/Comment/CommentAuthor.vue";
import HideButton from "@/Components/Comment/HideButton.vue";

const props = defineProps({
  comment: {
    type: Object,
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

const isOpen = ref(true);
</script>

<template>
  <div :id="`comment_${comment.id}`">
    <div class="pb-6 pt-2 flex items-stretch">
      <HideButton
        :open="isOpen"
        :depth="depth"
        @click="() => isOpen = !isOpen"
      />

      <div
        class="inline-flex items-center pt-[0.175rem] cursor-pointer"
        v-show="!isOpen"
        @click="() => isOpen = !isOpen"
      >
        <p class="text-sky-600 text-base font-bold">
          Show comments ({{ comment.total_comments }})
        </p>
      </div>

      <div
        class="pr-4"
        v-show="isOpen"
      >
        <CommentAuthor
          class="mb-1"
          :author="comment.author"
          :created-date="comment.created_date"
        />

        <div class="mb-2 text-sm font-medium text-gray-700">
          {{ comment.text }}
        </div>

        <CommentReaction
          :comment-id="comment.id"
          :article-id="articleId"
          :is-bookmarked="false"
        />
      </div>
    </div>

    <div v-if="comment.comments.length > 0">
      <Comment
        v-for="comment in comment.comments"
        :key="comment.id"
        :comment="comment"
        :article-id="articleId"
        :depth="depth + 1"
      />
    </div>
  </div>
</template>
