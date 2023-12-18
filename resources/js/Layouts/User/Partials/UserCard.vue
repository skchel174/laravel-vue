<script setup>
import Avatar from "@/Components/Avatar.vue";

defineProps({
  user: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div>
    <Avatar
      size="md"
      :value="user.avatar"
      clickable
    />

    <h3 class="mt-2 text-base sm:text-lg font-medium text-sky-600">
      {{ user.name }}
    </h3>

    <p class="mt-1 text-sm text-gray-600 font-medium capitalize">
      user
    </p>
  </div>
</template>
