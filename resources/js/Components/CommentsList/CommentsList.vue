<script setup>
import CommentsListItem from "@/Components/CommentsList/CommentsListItem.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import nothingHere from 'img/nothing-here.svg';

defineProps({
  comments: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div>
    <div
      class="space-y-4"
      v-if="comments.items.length > 0"
    >
      <CommentsListItem
        v-for="comment in comments.items"
        :key="comment.id"
        :comment="comment"
      />

      <Pagination :items="comments"/>
    </div>

    <div v-else class="px-4 flex flex-col items-center justify-center">
      <img
        class="mt-10 w-64"
        :src="nothingHere"
        alt="nothing-here"
      />

      <p class="mt-4 text-sm text-gray-400 font-medium">
        {{ $trans('empty_comments') }}
      </p>
    </div>
  </div>
</template>
