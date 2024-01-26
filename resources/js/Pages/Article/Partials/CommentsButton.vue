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
    class="w-full flex justify-center p-4 bg-white text-base text-sky-600 font-bold hover:text-sky-700 transition duration-300"
    :href="route('article.comments', {article: articleId})"
    as="button"
  >
    <span class="mr-1">
      {{ $trans('Comments') }}
    </span>

    <span>({{ commentsCount }})</span>
  </Link>
</template>
