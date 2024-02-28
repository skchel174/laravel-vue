<script setup>
import BaseLayout from "@/Components/Layouts/BaseLayout.vue";
</script>

<template>
  <BaseLayout>
    <div class="w-full flex flex-row justify-between">
      <div class="flex-1 w-full">
        <slot/>
      </div>

      <div class="ml-4 w-75 hidden lg:block">
        <slot name="sidebar"/>
      </div>
    </div>
  </BaseLayout>
</template>
