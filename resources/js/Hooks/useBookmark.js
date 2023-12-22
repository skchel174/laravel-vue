import {ref} from "vue";
import axios from "axios";

function useBookmark(state = false) {
  const isBookmarked = ref(state);

  const toggleBookmark = (url) => {
    isBookmarked.value = !isBookmarked.value;

    return axios({
      method: isBookmarked.value ? 'post' : 'delete',
      url,
    });
  };

  return {
    isBookmarked,
    toggleBookmark,
  }
}

export default useBookmark;
