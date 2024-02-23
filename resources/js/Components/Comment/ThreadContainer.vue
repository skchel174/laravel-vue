<script setup>
import {ref} from "vue";
import Comment from "@/Components/Comment/Comment.vue";
import ThreadBreadcrumbs from "@/Components/Comment/ThreadBreadcrumbs.vue";

const props = defineProps({
  comments: {
    type: Array,
    required: true,
  },

  commentsCount: {
    type: Number,
    required: true,
  },

  depth: {
    type: Number,
    required: true,
  },
});

const isThreadOpen = ref(true);
</script>

<template>
  <div>

    <div v-if="isThreadOpen">
      <div class="py-2 flex">
        <ThreadBreadcrumbs
          :open="isThreadOpen"
          :depth="depth"
          @click="isThreadOpen = !isThreadOpen"
        />

        <div class="w-full">
          <slot/>
        </div>
      </div>

      <Comment
        v-for="comment in comments"
        :key="comment.id"
        :comment="comment"
        :depth="depth + 1"
      />
    </div>

      <div v-else class="py-2 flex">
        <ThreadBreadcrumbs
          :open="isThreadOpen"
          :depth="depth"
          @click="isThreadOpen = !isThreadOpen"
        />

        <div
          class="h-8 pt-1 flex items-center text-sm font-semibold text-sky-700/75 cursor-pointer leading-none"
          @click="isThreadOpen = true"
        >
          {{ $trans('Show comments') }} ({{ commentsCount + 1 }})
        </div>
      </div>
  </div>
</template>
