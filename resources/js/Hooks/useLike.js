import {ref} from "vue";
import axios from "axios";

function useLike(state, count) {
  const isLiked = ref(state);
  const likesCount = ref(count);

  const toggleLike = (url) => {
    isLiked.value = !isLiked.value;
    likesCount.value += isLiked.value ? 1 : -1;

    axios({
      method: isLiked.value ? 'post' : 'delete',
      url,
    });
  };

  return {
    isLiked,
    likesCount,
    toggleLike,
  }
}

export default useLike;
