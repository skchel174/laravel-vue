import {ref} from "vue";
import axios from "axios";
import {usePage} from "@inertiajs/vue3";

function useBookmark(state = false) {
  const isBookmarked = ref(state);

  const user = usePage().props.auth.user;

  const toggleBookmark = async (url) => {
    if (!user) {
      throw new Error('Login to bookmark');
    }

    isBookmarked.value = !isBookmarked.value;

    const method = isBookmarked.value ? 'post' : 'delete';

    return axios({method, url});
  };

  return {isBookmarked, toggleBookmark}
}

export default useBookmark;
