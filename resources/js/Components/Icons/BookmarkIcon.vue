<script setup>
import {ref} from "vue";

const props = defineProps({
  isBookmarked: {
    type: Boolean,
    required: true,
  },

  disabled: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['bookmark']);

const isBookmarked = ref(props.isBookmarked);

const toggleBookmark = () => {
  if (props.disabled) {
    return;
  }

  isBookmarked.value = !isBookmarked.value;
  emit('bookmark', isBookmarked.value);
};
</script>

<template>
  <span
    class="material-icons text-gray-300 !text-2xl hover:text-gray-400 active:scale-[0.95] cursor-pointer transition duration-200 select-none"
    :class="{['!text-gray-500 hover:!text-gray-600']: isBookmarked}"
    @click="toggleBookmark"
  >
    bookmark
  </span>
</template>
