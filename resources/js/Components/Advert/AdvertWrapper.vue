<script setup>
import AdvertIcon from "@/Components/Icons/AdvertIcon.vue";
</script>

<template>
  <div class="w-full flex flex-row justify-between">
    <div class="flex-1 mb-4 lg:mb-0 lg:mr-4 w-full max-w-3xl">
      <slot/>
    </div>

    <div class="w-full max-w-3xl lg:w-64 h-64 bg-gray-200 hidden lg:flex justify-center items-center">
      <AdvertIcon class="h-12 w-12 text-gray-400"/>
    </div>
  </div>
</template>
