<script setup>
import {computed, onUnmounted, watch} from 'vue';

const props = defineProps({
  open: {
    type: Boolean,
    default: false,
  },

  maxWidth: {
    type: String,
    default: '2xl',
  },
});

const emit = defineEmits(['update:open']);

const closeOnEscape = (e) => {
  if (e.key === 'Escape' && props.open) {
    emit('update:open', false);
  }
};

watch(() => props.open, (open) => {
  if (open) {
    document.addEventListener('keydown', closeOnEscape);
    document.body.style.overflow = 'hidden';
  } else {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
  }
});

onUnmounted(() => {
  document.removeEventListener('keydown', closeOnEscape);
  document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
  return {
    sm: 'sm:max-w-sm',
    md: 'sm:max-w-md',
    lg: 'sm:max-w-lg',
    xl: 'sm:max-w-xl',
    '2xl': 'sm:max-w-2xl',
  }[props.maxWidth];
});
</script>

<template>
  <Teleport to="body">
    <Transition leave-active-class="duration-200">
      <div
        v-show="open"
        class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 flex justify-center items-center"
        scroll-region
      >
        <Transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="ease-in duration-200"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div
            v-show="open"
            class="fixed inset-0 transform transition-all"
            @click="$emit('update:open', false)"
          >
            <div class="absolute inset-0 bg-gray-500 opacity-75"/>
          </div>
        </Transition>

        <Transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to-class="opacity-100 translate-y-0 sm:scale-100"
          leave-active-class="ease-in duration-200"
          leave-from-class="opacity-100 translate-y-0 sm:scale-100"
          leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
          <div
            v-show="open"
            class="mb-6 bg-white rounded-sm overflow-hidden transform transition-all sm:w-full sm:mx-auto"
            :class="maxWidthClass"
          >
            <slot v-if="open"/>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>
