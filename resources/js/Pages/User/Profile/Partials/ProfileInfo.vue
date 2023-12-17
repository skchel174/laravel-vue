<script setup>
defineProps({
  user: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div class="space-y-4">
    <div class="space-y-2">
      <h5 class="text-sm text-gray-700 font-bold">
        Registered
      </h5>

      <p class="text-sm text-gray-500 font-medium">
        {{ user.created_at }}
      </p>
    </div>

    <div class="space-y-2">
      <h5 class="text-sm text-gray-700 font-bold">
        Activity
      </h5>

      <p class="text-sm text-gray-500 font-medium">
        {{ $formatDate(user.login_at, 'DD MMM YYYY') }}
      </p>
    </div>
  </div>
</template>
