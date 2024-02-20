import axios from "axios";
import {inject, ref} from "vue";
import {usePage} from "@inertiajs/vue3";

function useLike(state, count) {
  const isLiked = ref(state);
  const likesCount = ref(count);

  const loading = ref(false);

  const page = usePage();
  const notify = inject('notify');

  const toggleLike = (url) => {
    if (!page.props.auth.user) {
      notify('error', 'Authorization required');
      return;
    }

    loading.value = true;

    const method = isLiked.value ? 'delete' : 'post';

    axios({method, url})
      .then(() => {
        isLiked.value = !isLiked.value;
        likesCount.value += isLiked.value ? 1 : -1;
      })
      .finally(() => loading.value = false);
  };

  return {
    loading,
    isLiked,
    likesCount,
    toggleLike,
  };
}

export default useLike;
