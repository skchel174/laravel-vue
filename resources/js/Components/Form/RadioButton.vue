<script setup>
defineProps({
  selected: {
    type: Boolean,
    required: true,
  },

  label: {
    type: String,
  },
});

defineEmits(['select'])
</script>

<template>
  <div class="flex items-center space-x-2">
    <div
      class="h-[1.125rem] w-[1.125rem] flex justify-center items-center border border-gray-300 rounded-full cursor-pointer shrink-0"
      @click="$emit('select')"
    >
      <Transition
        enter-from-class="scale-0"
        enter-active-class="transition duration-200"
        enter-to-class="scale-100"
        leave-from-class="scale-100"
        leave-active-class="transition duration-50"
        leave-to-class="scale-0"
      >
        <div
          class="h-2.5 w-2.5 bg-sky-600 rounded-full"
          v-if="selected"
        />
      </Transition>
    </div>

    <span
      class="font-medium text-sm text-gray-700 cursor-pointer select-none"
      v-if="label"
      @click="$emit('select')"
    >
      {{ label }}
    </span>
  </div>
</template>
