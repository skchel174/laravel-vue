<script setup>
import {Link} from "@inertiajs/vue3";
import {computed, onMounted, ref} from "vue";

const props = defineProps({
  active: {
    type: Boolean,
    default: true,
  },
});

const el = ref(null);

const component = computed(() => props.active ? Link : 'div');

onMounted(() => {
  if (!props.active) {
    el.value.removeAttribute('href');
  }
});
</script>

<template>
  <component
    :is="component"
    ref="el"
    class="h-full flex justify-center items-center text-sm font-semibold text-gray-700 hover:text-sky-700/75 transition duration-200"
    :class="{'!text-gray-400/75': !active}"
  >
    <slot/>
  </component>
</template>
