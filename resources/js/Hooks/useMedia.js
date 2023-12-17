import {ref, watchEffect} from "vue";

function useMedia(query) {
  const matches = ref(true);

  watchEffect((onCleanup) => {
    const media = window.matchMedia(query);

    if(matches.value !== media.matches) {
      matches.value = media.matches;
    }

    const onChange = () => matches.value = media.matches;

    media.addEventListener('change', onChange);

    onCleanup(() => {
      media.removeEventListener('change', onChange);
    });
  });

  return matches;
}

export default useMedia;
