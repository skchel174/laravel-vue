<script setup>
import {Link} from "@inertiajs/vue3";
import nothingHere from 'img/nothing-here.svg';
</script>

<template>
  <div class="px-4 sm:px-6 flex flex-col items-center justify-center space-y-4">
    <img
      class="w-64"
      :src="nothingHere"
      alt="nothing-here"
    />

    <div class="text-sm text-gray-400 font-medium space-x-1">
      <span>{{ $trans('Unfortunately no topics found') }}.</span>

      <Link
        class="text-sky-600/75"
        href="#"
      >
        {{ $trans('Suggest a new topic') }}?
      </Link>
    </div>
  </div>
</template>
