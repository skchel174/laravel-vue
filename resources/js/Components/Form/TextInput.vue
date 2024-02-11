<script setup>
import {ref} from "vue";

const props = defineProps({
  modelValue: {
    type: String,
    required: true,
  },
});

const isFocused = ref(false);
</script>

<template>
  <div
    class="flex border border-gray-300 rounded-sm transition duration-400"
    :class="{'border-sky-500/70': isFocused}"
  >
    <slot name="before"/>

    <input
      v-bind="$attrs"
      class="flex-1 focus:ring-0 border-none placeholder:text-sm placeholder:text-gray-500"
      type="text"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      @focus="isFocused = true"
      @blur="isFocused = false"
    />

    <slot name="after"/>
  </div>
</template>
