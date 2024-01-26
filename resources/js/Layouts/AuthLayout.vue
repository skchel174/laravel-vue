<script setup>
import {Link} from "@inertiajs/vue3";
</script>

<template>
  <div class="h-full flex flex-col bg-white sm:bg-gray-100">
    <header class="py-8 sm:p-4 flex justify-center sm:justify-start bg-white sm:border-b border-gray-200">
      <Link :href="route('main')">
        <h1 class="text-3xl sm:text-4xl font-black">
          {{ $trans('Feed') }}
        </h1>
      </Link>
    </header>

    <div class="w-full flex-1 flex flex-col justify-center items-center">
      <slot/>
    </div>
  </div>
</template>
