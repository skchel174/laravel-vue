<script setup>
import {computed, onUnmounted, watch} from "vue";

defineOptions({
  inheritAttrs: false,
});

const props = defineProps({
  open: {
    type: Boolean,
    required: true,
  },

  side: {
    type: String,
    required: true,
    validator: (value) => {
      return ['top', 'left', 'right'].includes(value);
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

const wrapperClass = computed(() => {
  if (props.side === 'top') {
    return 'flex-col justify-start';
  }

  return props.side === 'left' ? 'justify-start' : 'justify-end'
});

const contentClass = computed(() => {
  return props.side === 'top' ? 'w-screen' : 'w-9/12 h-screen max-w-[18rem]';
});

const hiddenState = computed(() => {
  if (props.side === 'top') {
    return 'translate-y-[-100%]';
  }

  if (props.side === 'left') {
    return 'translate-x-[-100%]';
  }

  if (props.side === 'right') {
    return 'translate-x-[100%]';
  }
});

const visibleState = computed(() => {
  if (props.side === 'top') {
    return 'translate-y-0';
  }

  if (props.side === 'left' || props.side === 'right') {
    return 'translate-x-0';
  }
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
        :class="wrapperClass"
        v-bind="$attrs"
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
          :enter-from-class="hiddenState"
          :enter-to-class="visibleState"
          leave-active-class="ease-in duration-200"
          :leave-from-class="visibleState"
          :leave-to-class="hiddenState"
        >
          <div
            v-if="open"
            class="bg-white overflow-y-auto transform transition-all"
            :class="contentClass"
          >
            <slot/>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>
