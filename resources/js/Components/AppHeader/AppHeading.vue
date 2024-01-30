<script setup>
import {Link} from "@inertiajs/vue3";
</script>

<template>
  <Link :href="route('main')">
    <h1 class="text-2xl text-white font-black hover:text-gray-300 transition duration-300">
      {{ $trans('Feed') }}
    </h1>
  </Link>
</template>
