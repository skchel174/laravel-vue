<script setup>
import {onUnmounted, ref, watch} from "vue";

const props = defineProps({
  open: {
    type: Boolean,
    required: true,
  },
});

const emit = defineEmits(['update:open']);

const el = ref(null);

const onClick = (event) => {
  if (!event.composedPath().includes(el.value)) {
    emit('update:open', false);
  }
};

watch(() => props.open, (open) => {
  if (open) {
    document.addEventListener('click', onClick);
  } else {
    document.removeEventListener('click', onClick);
  }
});

onUnmounted(() => {
  document.removeEventListener('click', onClick);
});
</script>

<template>
  <Transition
    enter-from-class="transform opacity-0 scale-95"
    enter-active-class="transition ease-out duration-100"
    enter-to-class="transform opacity-100 scale-100"
    leave-from-class="transform opacity-100 scale-100"
    leave-active-class="transition ease-in duration-75"
    leave-to-class="transform opacity-0 scale-95"
  >
    <div
      ref="el"
      class="absolute min-w-[10rem] shadow-md rounded border border-gray-200 bg-white z-50"
      v-show="open"
    >
      <slot/>
    </div>
  </Transition>
</template>
