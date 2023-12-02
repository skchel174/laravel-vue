<template>
  <button class="py-1.5 px-4 inline-flex items-center justify-center rounded-sm
    text-sm font-medium text-white
    bg-red-700 hover:bg-red-800 active:bg-red-900
    ring-1 ring-red-700 hover:ring-red-800 active:ring-red-900
    transition duration-200 ease-in-out
    disabled:opacity-75 disabled:cursor-not-allowed disabled:bg-red-800 disabled:ring-red-700
  ">
    <slot/>
  </button>
</template>
