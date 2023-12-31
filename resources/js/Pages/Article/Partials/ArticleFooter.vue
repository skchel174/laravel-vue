<script setup>
import {onMounted, onUnmounted, ref} from "vue";

const stickyPanel = ref(null);
const isStickyPanelVisible = ref(true);
const intersectObservable = ref(null);
const prevScrollOffset = ref(window.scrollY);

const onWindowScroll = () => {
  if (window.scrollY > intersectObservable.value.offsetTop) {
    return;
  }

  if (window.scrollY - prevScrollOffset.value > 1) {
    isStickyPanelVisible.value = false;
  } else if (window.scrollY - prevScrollOffset.value < 1) {
    isStickyPanelVisible.value = true;
  }

  prevScrollOffset.value = window.scrollY;
};

const onIntersect = ([entry]) => {
  if (entry.isIntersecting) {
    window.removeEventListener('scroll', onWindowScroll);
    isStickyPanelVisible.value = true;
  } else {
    window.addEventListener('scroll', onWindowScroll);
  }
};

const observer = new IntersectionObserver(onIntersect, {
  threshold: 0.5,
});

onMounted(() => {
  observer.observe(intersectObservable.value);
});

onUnmounted(() => {
  window.removeEventListener('scroll', onWindowScroll);
  observer.disconnect();
});
</script>

<template>
  <div ref="intersectObservable"/>

  <Transition
    enter-from-class="!bottom-[-3rem]"
    enter-active-class="transition transition-[bottom] duration-300"
    enter-to-class="bottom-0"
    leave-from-class="bottom-0"
    leave-active-class="transition transition-[bottom] duration-300"
    leave-to-class="!bottom-[-3rem]"
  >
    <footer
      class="sticky px-4 h-[3rem] flex items-center border-t border-gray-200 bg-white stickyPanel"
      v-show="isStickyPanelVisible"
      ref="stickyPanel"
    >
      <slot/>
    </footer>
  </Transition>
</template>

<style>
.stickyPanel {
  bottom: 0;
}
</style>
