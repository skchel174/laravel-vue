import {ref} from "vue";
import axios from "axios";

function useSubscription(state) {
  const subscription = ref(state);

  const loading = ref(false);

  const subscribe = (url) => {
    loading.value = true;

    axios.post(url)
      .then(() => subscription.value = true)
      .finally(() => loading.value = false);
  };

  const unsubscribe = (url) => {
    loading.value = true;

    axios.delete(url)
      .then(() => subscription.value = false)
      .finally(() => loading.value = false);
  };

  return {
    loading,
    subscription,
    subscribe,
    unsubscribe,
  };
}

export default useSubscription;
