<script setup>
import {computed} from "vue";

const props = defineProps({
  username: {
    type: String,
    required: true,
  },

  avatar: {
    type: String,
  },

  size: {
    type: String,
    default: 'sm',
  },
});

const size = computed(() => {
  switch (props.size) {
    case 'lg':
      return 'w-16 h-16 text-2xl';
    case 'md':
      return 'w-12 h-12 text-xl';
    case 'sm':
      return 'w-10 h-10 text-lg';
    case 'xs':
      return 'w-8 h-8 text-base';
  }
});
</script>

<template>
  <div
    class="avatar flex justify-center items-center rounded border-[1.5px] border-gray-500 text-gray-600 font-medium capitalize"
    :class="[size, avatar ? 'border-none' : '']"
  >
    <img
      class="rounded w-full h-full"
      v-if="avatar"
      :src="avatar"
      alt="avatar"
    >

    <span v-else>
      {{ username[0] }}
    </span>
  </div>
</template>
