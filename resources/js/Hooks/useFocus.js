import {onMounted, onUnmounted, ref} from "vue";

function useFocus(elementRef) {
  const focus = ref(false);

  const onClick = (event) => {
    focus.value = event.composedPath().includes(elementRef.value);
  };

  onMounted(() => {
    document.addEventListener('click', onClick);
  });

  onUnmounted(() => {
    document.removeEventListener('click', onClick);
  });

  return focus;
}

export default useFocus;
