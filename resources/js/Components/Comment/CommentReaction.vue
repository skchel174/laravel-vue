<script setup>
import BookmarkIcon from "@/Components/Icons/BookmarkIcon.vue";
import CommentsIcon from "@/Components/Icons/CommentsIcon.vue";

defineProps({
  isBookmarked: {
    type: Boolean,
    required: true,
  },

  commentsCount: {
    type: Number,
    required: true,
  },
});

defineEmits(['copy', 'bookmarked']);
</script>

<template>
  <div class="w-full flex items-center justify-between sm:justify-start sm:space-x-4 text-gray-400">
    <CommentsIcon :count="commentsCount"/>

    <span class="text-sm text-gray-400 cursor-pointer hover:text-gray-500 transition duration-200 select-none">
      Reply
    </span>

    <BookmarkIcon
      :is-bookmarked="isBookmarked"
      @toggle="$emit('bookmarked')"
    />

    <span
      class="material-icons text-gray-300 !text-2xl hover:text-gray-400 active:scale-[0.95] cursor-pointer transition duration-200 select-none"
      @click="$emit('copy')"
    >
      link
    </span>
  </div>
</template>
