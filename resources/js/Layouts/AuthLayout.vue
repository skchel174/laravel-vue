<script setup>
import {Link} from "@inertiajs/vue3";

</script>

<template>
  <div class="h-full flex flex-col">
    <header class="py-8 sm:p-4 flex justify-center sm:justify-start sm:border-b border-gray-200">
      <Link
        class="text-5xl sm:text-2xl font-black capitalize"
        :href="route('main')"
      >
        App
      </Link>
    </header>
    <div class="w-full flex-1 flex flex-col justify-center items-center">
      <slot/>
    </div>
  </div>
</template>

