<script setup>
import {onUnmounted, watch} from "vue";

const props = defineProps({
  open: {
    type: Boolean,
    required: true,
  },

  side: {
    type: String,
    required: true,
    validator: (value) => {
      return ['left', 'right'].includes(value);
    },
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
</script>

<template>
  <Teleport to="body">
    <Transition
      enter-active-class="duration-200"
      leave-active-class="delay-300"
    >
      <div
        v-show="open"
        class="fixed inset-0 overflow-y-auto z-50 flex"
        :class="side === 'left' ? 'justify-start' : 'justify-end'"
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
            <div class="absolute inset-0 bg-black opacity-50"/>
          </div>
        </Transition>

        <Transition
          enter-active-class="ease-out duration-300"
          :enter-from-class="side === 'left' ? 'translate-x-[-100%]' : 'translate-x-[100%]'"
          enter-to-class="translate-x-0"
          leave-active-class="ease-in duration-200"
          leave-from-class="translate-x-0"
          :leave-to-class="side === 'left' ? 'translate-x-[-100%]' : 'translate-x-[100%]'"
        >
          <div
            v-if="open"
            class="w-9/12 h-screen max-w-[18rem] bg-white overflow-y-auto transform transition-all"
          >
            <slot/>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>
