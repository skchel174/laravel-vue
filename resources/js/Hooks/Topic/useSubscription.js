import {ref} from "vue";
import axios from "axios";

function useSubscription(state) {
  const subscribed = ref(state);

  const subscribe = (topic) => {
    subscribed.value = true;
    return axios.post(route('api.topics.subscription', {topic}));
  };

  const unsubscribe = (topic) => {
    subscribed.value = false;
    return axios.delete(route('api.topics.subscription', {topic}));
  };

  return {
    subscribed,
    subscribe,
    unsubscribe,
  };
}

export default useSubscription;
