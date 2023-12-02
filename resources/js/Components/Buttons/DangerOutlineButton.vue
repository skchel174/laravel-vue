<template>
  <button class="py-1.5 px-4 inline-flex items-center justify-center rounded-sm
    text-sm text-red-700 font-medium hover:text-white active:text-white
    bg-white hover:bg-red-700 active:bg-red-800
    ring-1 ring-red-700 hover:ring-red-700 active:ring-red-800
    transition ease-in-out duration-200
    disabled:opacity-75 disabled:cursor-not-allowed disabled:bg-white disabled:text-red-700 disabled:ring-red-700
  ">
    <slot/>
  </button>
</template>
