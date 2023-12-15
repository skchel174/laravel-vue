<script setup>
import articles_placeholder from "img/articles.png";
</script>

<template>
  <div class="w-full flex flex-col items-center space-y-8">
    <img
      class="w-10/12 sm:w-8/12"
      :src="articles_placeholder"
      alt="articles"
    >

    <p class="text-base text-gray-400 font-bold">
      Unfortunately there are no articles here yet
    </p>
  </div>
</template>
