<script setup>
import Avatar from "@/Components/Avatar.vue";

defineProps({
  author: {
    type: Object,
    required: true,
  },

  createdDate: {
    type: String,
    required: true,
  },
})
</script>

<template>
  <header class="flex items-center space-x-2">
    <Avatar
      :value="author.avatar"
      size="xs"
    />

    <div class="flex flex-wrap items-center">
      <p class="text-sm text-gray-600 font-semibold !leading-4 mr-2">
        {{ author.name }}
      </p>

      <p class="text-xs text-gray-400 font-bold">
        {{ $formatDate(createdDate, 'MMM D YYYY [at] kk:mm') }}
      </p>
    </div>
  </header>
</template>
