<template>
  <button :class="[
    'py-1.5', 'sm:py-2', 'px-4', 'inline-flex', 'items-center', 'justify-center', 'rounded-sm',
    'text-xs', 'text-white', 'font-semibold',
    'bg-sky-600', 'hover:bg-sky-700', 'active:bg-sky-800',
    'ring-1', 'ring-sky-600', 'hover:ring-sky-700', 'active:ring-sky-800',
    'transition', 'duration-200', 'ease-in-out',
    'disabled:opacity-75', 'disabled:cursor-not-allowed', 'disabled:bg-sky-600', 'disabled:ring-sky-600',
  ]">
    <slot/>
  </button>
</template>
