<script setup>
defineProps({
  heading: {
    type: String,
    required: true,
  },

  values: {
    typ: Array,
    required: true,
  },

  modelValue: {
    type: String,
    required: true,
  },
});

defineEmits(['update:modelValue']);
</script>

<template>
  <div class="space-y-2">
    <h6 class="text-sm text-gray-700 font-semibold">
      {{ $trans(heading) }}
    </h6>

    <div class="flex space-x-2">
      <div
        v-for="value in values"
        :key="value"
        class="py-1.5 px-2.5 border text-xs text-sky-700/75 border-sky-700/75 rounded-sm transition duration-200 cursor-pointer"
        :class="{'text-stone-50 bg-sky-700/75': value === modelValue}"
        @click="$emit('update:modelValue', value)"
      >
        {{ $ucfirst($trans(value)) }}
      </div>
    </div>
  </div>
</template>
