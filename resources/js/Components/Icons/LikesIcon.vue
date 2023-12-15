<script setup>
import {ref} from "vue";

const props = defineProps({
  isLiked: {
    type: Boolean,
    required: true,
  },

  count: {
    type: Number,
    required: true,
  },

  disabled: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['like']);

const isLiked = ref(props.isLiked);

const toggleLike = () => {
  if (props.disabled) {
    return;
  }

  isLiked.value = !isLiked.value;
  emit('like', isLiked.value);
};
</script>

<template>
  <div class="flex items-center justify-center">
    <span
      class="material-icons !text-xl text-gray-300 hover:text-gray-400 active:scale-[0.95] cursor-pointer transition duration-200 select-none"
      :class="{['!text-gray-500 hover:!text-gray-600']: isLiked}"
      @click="toggleLike"
    >
      favorite
    </span>
    <span class="text-xs font-medium text-gray-400 ml-2">
      {{ $formatCount($props.count) }}
    </span>
  </div>
</template>
