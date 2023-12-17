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
    class="h-full px-2 flex justify-center items-center hover:text-sky-600 transition duration-200"
    :class="{'!text-gray-500 !hover:text-gray-500': !active}"
  >
    <slot/>
  </component>
</template>
