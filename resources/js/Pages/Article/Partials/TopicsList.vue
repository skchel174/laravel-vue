<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
  topics: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div class="flex flex-wrap space-x-2 items-center">
    <span class="mr-1 text-base font-bold capitalize">
      {{ $trans('Topics') }}:
    </span>

    <Link
      class="text-sky-600 text-base font-medium hover:text-sky-500 transition duration-300 after:content-[','] after:last:content-['']"
      v-for="topic in topics"
      :key="topic.id"
      href="#"
    >
      {{ topic.name }}
    </Link>
  </div>
</template>
