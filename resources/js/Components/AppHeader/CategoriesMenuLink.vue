<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
  selected: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <Link
    class="relative px-6 py-3 text-base text-gray-700 font-medium hover:bg-sky-50 active:bg-sky-100 hover:text-sky-600 transition duration-300"
    :class="{'text-sky-600 before:absolute before:top-0 before:left-0 before:content-[\'\'] before:bg-sky-600 before:h-full before:w-0.5': selected}"
  >
    <slot/>
  </Link>
</template>
