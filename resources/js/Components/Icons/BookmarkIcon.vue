<script setup>
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import RotateLoader from 'vue-spinner/src/ClipLoader.vue'

defineProps({
  isBookmarked: {
    type: Boolean,
    required: true,
  },

  loading: {
    type: Boolean,
    default: false,
  },
});

defineEmits(['toggle']);
</script>

<template>
  <div class="w-4 flex items-center justify-center">
    <MaterialIcon
      v-if="!loading"
      class="!text-2xl text-gray-300 cursor-pointer"
      :class="{['text-gray-500/75']: isBookmarked}"
      @click="$emit('toggle')"
    >
      bookmark
    </MaterialIcon>

    <RotateLoader
      v-else
      class="flex"
      size=".85rem"
      color="#d1d5db"
    />
  </div>
</template>
