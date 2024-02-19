<script setup>
defineProps({
  user: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div class="space-y-4 text-sm">
    <div class="space-y-2">
      <h5 class=" text-gray-700 font-bold">
        {{ $trans('Registered') }}
      </h5>
      <p class="text-gray-500">
        {{ $formatDate(user.created_at, 'DD MMM YYYY') }}
      </p>
    </div>

    <div class="space-y-2">
      <h5 class="text-gray-700 font-bold">
        {{ $trans('Activity') }}
      </h5>
      <p class="text-gray-500">
        {{ $formatDate(user.login_at, 'DD MMM YYYY') }}
      </p>
    </div>
  </div>
</template>
