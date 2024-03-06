<script setup>
import {ref, watch} from "vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

const props = defineProps({
  visible: {
    type: Boolean,
    required: true,
  },

  type: {
    type: String,
    default: 'info',
  },

  duration: {
    type: [Number, null],
    default: 20000,
  },
});

const emit = defineEmits(['update:visible']);

const types = {
  info: 'bg-sky-100 text-sky-700',
  success: 'bg-green-100 text-green-700',
  warning: 'bg-yellow-100 text-yellow-700',
  error: 'bg-red-100 text-red-700',
};

const notificationRef = ref(null);

const setNotificationOffset = () => {
  const offset = document.body.offsetWidth / 2 - notificationRef.value.offsetWidth / 2;
  notificationRef.value.style.left = offset + 'px';
  notificationRef.value.style.right = offset + 'px';
}

watch(() => props.visible, () => {
  if (props.visible && props.duration) {
    // setTimeout(() => emit('update:visible', false), props.duration);
  }
});

watch(notificationRef, () => {
  if (props.visible) {
    setNotificationOffset();
    window.addEventListener('resize', setNotificationOffset);
  } else {
    window.removeEventListener('resize', setNotificationOffset);
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
        v-if="visible"
        ref="notificationRef"
        class="fixed top-4 px-2 min-w-[24rem] max-w-lg z-50"
      >
        <div
          class="rounded shadow-md px-6 pt-4 pb-4 text-sm font-medium flex flex-col justify-center items-center text-center"
          :class="types[type]"
          @click="$emit('update:visible', false)"
        >
          <slot/>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>
