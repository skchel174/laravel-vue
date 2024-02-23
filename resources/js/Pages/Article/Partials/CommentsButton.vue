<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
  articleId: {
    type: Number,
    required: true,
  },

  commentsCount: {
    type: Number,
    required: true,
  },
});
</script>

<template>
  <Link
    class="w-full flex justify-center p-4 bg-white text-base font-bold text-sky-675 hover:text-sky-775 transition duration-200"
    :href="route('article.comments', {article: articleId})"
    as="button"
  >
    <span class="mr-1 capitalize">
      {{ $trans('comments') }}
    </span>

    <span>({{ commentsCount }})</span>
  </Link>
</template>
