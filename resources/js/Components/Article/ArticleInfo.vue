<script setup>
import DifficultyIcon from "@/Components/Icons/DifficultyIcon.vue";
import DurationIcon from "@/Components/Icons/DurationIcon.vue";
import ViewsIcon from "@/Components/Icons/ViewsIcon.vue";

defineProps({
  viewsCount: {
    type: Number,
    required: true,
  },

  difficulty: {
    type: [String, null],
  },

  duration: {
    type: [Number, null],
  },
});
</script>

<template>
  <div class="flex items-center space-x-4">
    <DifficultyIcon
      v-if="difficulty"
      :value="difficulty"
    />

    <DurationIcon
      v-if="duration"
      :value="duration"
    />

    <ViewsIcon :count="viewsCount"/>
  </div>
</template>
