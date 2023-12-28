<script setup>
import {computed} from "vue";

const props = defineProps({
  open: {
    type: Boolean,
    required: true,
  },

  depth: {
    type: Number,
    required: true,
  },
});

const depthWidth = computed(() => props.depth * 16);
</script>

<template>
  <div
    class="px-1 cursor-pointer"
    :class="`w-[${depthWidth}px]`"
  >
    <div class="flex items-center pt-[0.55rem]">
      <div
        class="mx-0.5 h-1 w-1 rounded-full bg-gray-300"
        v-for="n in depth"
        :key="n"
      />

      <div
        v-if="open"
        class="mx-0.5 h-2 w-2 rounded-full border-2 border-gray-300 bg-white"
      />

      <div
        class="mx-0.5 w-3 h-3 rounded-full border-2 border-sky-600 flex items-center justify-center"
        v-else
      >
        <div class="mx-0.5 h-1 w-1 rounded-full bg-sky-600"/>
      </div>
    </div>
  </div>
</template>
