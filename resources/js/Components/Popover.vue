<script setup>
import {nextTick, onUnmounted, ref, watch} from "vue";

const props = defineProps({
  open: {
    type: Boolean,
    required: true,
  },

  anchorEl: {
    type: Object,
  },

  position: {
    type: String,
    default: 'start',
    validate: (value) => ['start', 'center', 'end'].includes(value),
  }
});

const emit = defineEmits(['update:open']);

const el = ref(null);

const onClick = (event) => {
  const path = event.composedPath();

  if (path.includes(el.value)) {
    return;
  }

  if (props.anchorEl && path.includes(props.anchorEl)) {
    return;
  }

  emit('update:open', false);
};

const calcLeftOffset = () => {
  if (!props.anchorEl) {
    return;
  }

  const popoverWidth = el.value.offsetWidth;
  const popoverHeight = el.value.offsetHeight;
  const documentWidth = document.documentElement.clientWidth;
  const documentHeight = document.documentElement.clientHeight;
  const anchor = props.anchorEl.getBoundingClientRect();

  const attachBottomLeft = () => {
    el.value.style.left = anchor.left + 'px';
  };

  const attachBottomRight = () => {
    el.value.style.left = anchor.right - popoverWidth + 'px';
  };

  const stickToRight = () => {
    if (anchor.right < documentWidth) {
      el.value.style.left = 'unset';
      el.value.style.right = '5px';
    } else {
      attachBottomRight();
    }
  };

  const stickToLeft = () => {
    if (anchor.right - popoverWidth < 0) {
      el.value.style.left = '5px';
      el.value.style.right = 'unset';
    } else {
      attachBottomLeft();
    }
  };

  el.value.style.inset = 'unset';

  if (props.position === 'start') {
    attachBottomLeft();

    if (anchor.left + popoverWidth > documentWidth) {
      stickToRight();
    }
  } else if (props.position === 'end') {
    attachBottomRight();

    if (anchor.right < popoverWidth) {
      stickToLeft();
    }
  } else {
    const popoverHalf = popoverWidth / 2;
    const anchorCenter = anchor.left + anchor.width / 2;

    el.value.style.left = anchorCenter - popoverHalf + 'px';

    if (anchorCenter - popoverHalf < 0) {
      stickToLeft();
    }

    if (anchorCenter + popoverHalf > documentWidth) {
      stickToRight();
    }
  }

  if (anchor.bottom + popoverHeight > documentHeight) {
    el.value.style.top = anchor.top - popoverHeight + 'px';
  }

  if (anchor.top < popoverHeight) {
    el.value.style.top = anchor.bottom + 'px';
  }
};

watch(() => props.open, (open) => {
  if (open) {
    document.addEventListener('click', onClick);
    window.addEventListener('resize', calcLeftOffset);
    nextTick(calcLeftOffset);
  } else {
    document.removeEventListener('click', onClick);
    window.removeEventListener('resize', calcLeftOffset);
  }
});

onUnmounted(() => {
  document.removeEventListener('click', onClick);
  window.removeEventListener('resize', calcLeftOffset);
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
      @click.stop
    >
      <slot/>
    </div>
  </Transition>
</template>
