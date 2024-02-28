<script setup>
import {ref} from "vue";

const props = defineProps({
  modelValue: {
    type: Boolean,
    required: true,
  },

  name: {
    type: String,
  },

  id: {
    type: String,
  },

  label: {
    type: String,
  },
});

const emit = defineEmits(['update:modelValue']);

const inputRef = ref(null);

const triggerRadioButton = () => {
  inputRef.value.click();
};

const toggleRadioButton = (event) => {
  emit('update:modelValue', event.target.value);
};
</script>

<template>
  <div class="flex items-center space-x-2">
    <div
      class="h-[1.125rem] w-[1.125rem] flex justify-center items-center border border-gray-300 rounded-full cursor-pointer shrink-0"
      @click="triggerRadioButton"
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
          class="h-2.5 w-2.5 bg-sky-675 rounded-full"
          v-if="modelValue"
        />
      </Transition>
    </div>

    <input
      :id="id"
      type="radio"
      class="hidden"
      ref="inputRef"
      :checked="modelValue"
      @input="toggleRadioButton"
    >

    <label
      class="font-medium text-sm text-gray-700 cursor-pointer select-none"
      v-if="label"
      :for="id"
    >
      {{ label }}
    </label>
  </div>
</template>
