<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
  tags: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div class="flex flex-wrap space-x-2 items-center">
    <span class="mr-1 text-base font-bold">
      Tags:
    </span>

    <Link
      class="text-sky-600 text-base font-medium hover:text-sky-500 transition duration-300 after:content-[','] after:last:content-['']"
      v-for="tag in tags"
      :key="tag.id"
      href="#"
    >
      {{ tag.name }}
    </Link>
  </div>
</template>
