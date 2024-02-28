<script setup>
import {computed, ref} from "vue";
import useFocus from "@/Hooks/useFocus.js";

const props = defineProps({
  modelValue: {
    type: Array,
    required: true,
  },

  options: {
    type: Array,
    required: true,
  },

  placeholder: {
    type: String,
  },
});

const emit = defineEmits(['update:modelValue', 'input']);

const el = ref(null);

const focus = useFocus(el);

const input = ref('');

const onInput = (event) => {
  input.value = event.target.value;
  emit('input', input.value);
};

const selection = ref(props.modelValue);

const sortedOptions = computed(() => {
  return props.options.filter(option => {
    return !selection.value.some(i => i.id === option.id);
  }).sort((a, b) => {
    const volA = a.value.toLowerCase();
    const volB = b.value.toLowerCase();

    if (volA === volB) {
      return 0;
    }

    return volA > volB ? 1 : -1
  });
});

const addItem = (item) => {
  selection.value.push(item);
  emit('update:modelValue', selection.value);
};

const removeItem = (item) => {
  selection.value.splice(selection.value.findIndex(i => i.id === item.id), 1);
  emit('update:modelValue', selection.value);
};
</script>

<template>
  <div ref="el" class="relative w-full">
    <div
      class="min-h-[2rem] px-2 border border-gray-300 rounded flex flex-wrap bg-white"
      :class="{['rounded-b-none']: focus && sortedOptions.length > 0}"
    >
      <div
        class="px-2 py-1 my-1 mr-1 border border-sky-675 flex items-center text-xs text-sky-700 cursor-pointer space-x-2"
        v-for="option in selection"
        :key="option.id"
        @click="removeItem(option)"
      >
        <span>{{ option.value }}</span>

        <span class="material-icons !text-base !leading-3">
          close
        </span>
      </div>

      <input
        class="px-2 py-1 my-1 flex-1 min-w-[10rem] border-none !outline-none !ring-0 text-sm"
        :value="input"
        :placeholder="placeholder"
        @input="onInput"
      />
    </div>

    <div
      v-if="focus && sortedOptions.length > 0"
      class="absolute w-full max-h-[8rem] overflow-y-scroll py-2 bg-white border-x border-b border-gray-300 shadow-sm rounded-b z-10"
    >
      <div
        class="w-full px-4 py-1 hover:bg-gray-200 transition duration-200 text-sm cursor-pointer"
        v-for="option in sortedOptions"
        :key="option.id"
        @click="addItem(option)"
      >
        {{ option.value }}
      </div>
    </div>
  </div>
</template>
