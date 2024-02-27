<script setup>
import {ref} from "vue";

const props = defineProps({
  modelValue: {
    type: Boolean,
    required: true,
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

const triggerInput = () => {
  inputRef.value.click();
};

const toggleCheckbox = (event) => {
  emit('update:modelValue', event.target.checked);
};
</script>

<template>
  <div class="flex items-center space-x-2">
    <div
      class="h-[1rem] w-[1rem] flex justify-center items-center border border-gray-300 rounded-sm cursor-pointer shrink-0"
      :class="{'bg-sky-675 border-sky-675': modelValue}"
      @click="triggerInput"
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
          class="h-2.5 w-2.5 bg-sky-675 flex justify-center items-center rounded-sm"
          v-if="modelValue"
        >
          <span class="material-icons !text-base text-white select-none">
            check
          </span>
        </div>
      </Transition>
    </div>

    <input
      :id="id"
      ref="inputRef"
      class="hidden"
      type="checkbox"
      :checked="modelValue"
      @input="toggleCheckbox"
    >

    <label
      class="font-medium text-sm text-gray-700 cursor-pointer select-none"
      :for="id"
      v-if="label"
    >
      {{ label }}
    </label>
  </div>
</template>
