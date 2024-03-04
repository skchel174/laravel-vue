import axios from "axios";
import {inject, ref} from "vue";
import {usePage} from "@inertiajs/vue3";

function useBookmark(state = false) {
  const isBookmarked = ref(state);

  const loading = ref(false);

  const page = usePage();
  const notify = inject('notify');

  const toggleBookmark = (url) => {
    if (!page.props.auth.user) {
      notify('error', 'Authorization required');
      return;
    }

    loading.value = true;

    const method = isBookmarked.value ? 'delete' : 'post';

    axios({method, url})
      .then(() => isBookmarked.value = !isBookmarked.value)
      .catch(error => {
        const notification = error.response.data.notification;

        if (notification) {
          notify(notification.type, notification.message);
        }
      })
      .finally(() => loading.value = false);
  };

  return {
    loading,
    isBookmarked,
    toggleBookmark,
  };
}

export default useBookmark;
