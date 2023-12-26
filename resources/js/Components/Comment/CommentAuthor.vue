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
});
</script>

<template>
  <header class="flex items-center space-x-2">
    <Avatar
      :value="author.avatar"
      size="xs"
    />

    <div class="mr-4 flex flex-wrap items-end">
      <span class="text-sm text-gray-600 font-semibold !leading-none mr-2">
        {{ author.login }}
      </span>

      <span class="text-xs text-gray-400 font-bold !leading-none">
        {{ $formatDate(createdDate, 'MMM D YYYY [at] kk:mm') }}
      </span>
    </div>
  </header>
</template>
