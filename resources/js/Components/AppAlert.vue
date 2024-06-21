<script setup>
import {computed, ref, watch} from "vue";

const props = defineProps({
  type: {
    type: String,
    required: true,
    validator: (value) => {
      return ['info', 'success', 'warning', 'danger'].includes(value);
    },
  },

  visible: {
    type: Boolean,
    required: true,
  },

  duration: {
    type: [Number, null],
    default: 5000,
  },
});

const emit = defineEmits(['update:visible']);

const el = ref(null);

const styles = computed(() => {
  return {
    info: 'text-sky-600 bg-sky-50 border-sky-500 dark:text-sky-400 dark:bg-sky-950 dark:border-sky-400',
    success: 'text-green-600 bg-green-50 border-green-500 dark:text-green-400 dark:bg-green-950 dark:border-green-400',
    danger: 'text-red-600 bg-red-50 border-red-500 dark:text-red-400 dark:bg-red-950 dark:border-red-400',
  }[props.type];
});

const setOffset = () => {
  const offset = document.body.offsetWidth / 2 - el.value.offsetWidth / 2;
  el.value.style.left = el.value.style.right = offset + 'px';
}

watch(() => props.visible, () => {
  if (props.visible && props.duration) {
    setTimeout(() => emit('update:visible', false), props.duration);
  }
});

watch(el, () => {
  if (props.visible) {
    setOffset();
    window.addEventListener('resize', setOffset);
  } else {
    window.removeEventListener('resize', setOffset);
  }
});
</script>

<template>
  <Teleport to="body">
    <Transition
      enter-from-class="translate-y-[-100%]"
      enter-active-class="transition transition-transform duration-300 ease-out"
      enter-to-class="translate-y-0"
      leave-from-class="translate-y-0"
      leave-active-class="transition transition-transform duration-200 ease-in"
      leave-to-class="translate-y-[-100%]"
    >
      <div
        ref="el"
        v-if="visible"
        class="fixed z-50 top-4 min-w-96 w-full max-w-xl px-4"
      >
        <div
          class="rounded px-6 py-4 flex-center flex-col border text-sm font-medium"
          :class="styles"
          @click="$emit('update:visible', false)"
        >
          <slot/>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>
