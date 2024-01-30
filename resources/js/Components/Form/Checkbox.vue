<script setup>
defineProps({
  checked: {
    type: Boolean,
    required: true,
  },

  label: {
    type: String,
  },
});

defineEmits(['toggle']);
</script>

<template>
  <div class="flex items-center space-x-2">
    <div
      class="h-[1rem] w-[1rem] flex justify-center items-center border border-gray-300 rounded-sm cursor-pointer shrink-0"
      :class="{'bg-sky-600 border-sky-600': checked}"
      @click="$emit('toggle')"
    >
      <Transition
        enter-from-class="scale-0"
        enter-active-class="transition duration-300"
        enter-to-class="scale-100"
        leave-from-class="opacity-100"
        leave-active-class="transition duration-0"
        leave-to-class="opacity-0"
      >
        <div
          class="h-2.5 w-2.5 bg-sky-600 flex justify-center items-center rounded-sm"
          v-if="checked"
        >
          <span class="material-icons !text-base text-white select-none">
            check
          </span>
        </div>
      </Transition>
    </div>

    <span
      class="font-medium text-sm text-gray-700 cursor-pointer select-none"
      v-if="label"
      @click="$emit('toggle')"
    >
      {{ label }}
    </span>
  </div>
</template>
