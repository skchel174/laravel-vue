<template>
  <nav class="bg-white after:content-[''] after:block after:w-full after:border-b after:border-gray-200">
    <div class="px-4 flex overflow-auto lg:overflow-visible tabs-container space-x-6 sm:space-x-8">
      <slot/>
    </div>
  </nav>
</template>

<style>
.tabs-container::-webkit-scrollbar {
  width: 0;
  height: 0;
}
</style>

