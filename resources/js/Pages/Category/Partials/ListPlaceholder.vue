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

    <slot/>
  </div>
</template>
