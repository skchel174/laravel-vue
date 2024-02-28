<script setup>
defineProps({
  user: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div class="p-4 bg-white w-full lg:max-w-xs">
    <h2 class="text-sm text-gray-500 font-bold uppercase">
      {{ $trans('Information') }}
    </h2>

    <hr class="my-4 w-full bg-gray-200"/>

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
  </div>
</template>
