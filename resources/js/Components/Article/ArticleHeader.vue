<script setup>

</script>

<template>
  <header class="w-full flex flex-wrap items-center justify-between">
    <div class="order-2 sm:order-1">
      <slot/>
    </div>

    <div class="order-1 sm:order-2 w-full sm:w-auto space-x-2 flex justify-end">
      <slot name="actions"/>
    </div>
  </header>
</template>

