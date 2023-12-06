<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
  selected: {
    type: Boolean,
    default: false,
  }
});
</script>

<template>
  <Link
    class="text-sm text-gray-500 font-medium hover:text-sky-600 transition duration-300"
    :class="{'text-sky-600': selected}"
  >
    <slot/>
  </Link>
</template>
