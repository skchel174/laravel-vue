<script setup>
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import RotateLoader from 'vue-spinner/src/ClipLoader.vue'

defineProps({
  isLiked: {
    type: Boolean,
    required: true,
  },

  count: {
    type: Number,
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
  <div class="flex items-center justify-center">
    <div class="w-5 flex items-center justify-center">
      <MaterialIcon
        v-if="!loading"
        class=" !text-2xl text-gray-300 cursor-pointer"
        :class="{['text-gray-500/75']: isLiked}"
        @click="$emit('toggle')"
      >
        favorite
      </MaterialIcon>

      <RotateLoader
        v-else
        class="flex"
        size=".85rem"
        color="#d1d5db"
      />
    </div>

    <span class="text-xs font-medium text-gray-400 ml-2">
      {{ $formatCount(count) }}
    </span>
  </div>
</template>
