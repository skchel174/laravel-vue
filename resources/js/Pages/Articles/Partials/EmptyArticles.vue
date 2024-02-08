<script setup>
import nothingHere from 'img/nothing-here.svg';
</script>

<template>
  <div class="px-4 sm:px-6 flex flex-col items-center justify-center space-y-4">
    <img
      class="w-64"
      :src="nothingHere"
      alt="nothing-here"
    />

    <p class="text-sm text-gray-400 font-medium">
      {{ $trans('empty_articles') }}
    </p>
  </div>
</template>
