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
    <span class="mr-1 text-sm sm:text-base text-gray-800 font-semibold">
      {{ $trans('Tags') }}:
    </span>

    <!--  TODO: add tag link  -->
    <Link
      class="text-sm sm:text-base font-medium text-sky-675 hover:text-sky-775 transition duration-200 after:content-[','] after:last:content-['']"
      v-for="tag in tags"
      :key="tag.id"
      href="#"
    >
      {{ tag.name }}
    </Link>
  </div>
</template>
