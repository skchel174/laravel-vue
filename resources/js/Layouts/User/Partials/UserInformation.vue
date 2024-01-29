<script setup>
defineProps({
  user: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <table class="w-full max-w-xs">
    <tr>
      <td class="pb-1 text-sm text-gray-700 font-bold">
        {{ $trans('Registered') }}
      </td>
      <td class="pb-1 px-4 text-xs text-gray-700 font-medium">
        {{ $formatDate(user.created_at, 'DD MMM YYYY') }}
      </td>
    </tr>
    <tr>
      <td class="pt-2 text-sm text-gray-700 font-bold">
        {{ $trans('Activity') }}
      </td>
      <td class="pt-2 px-4 text-xs text-gray-700 font-medium">
        {{ $formatDate(user.login_at, 'DD MMM YYYY') }}
      </td>
    </tr>
  </table>
</template>
