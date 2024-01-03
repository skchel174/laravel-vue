import axios from "axios";
import {ref} from "vue";

function useSubscription(state = false) {
  const subscription = ref(state);

  const follow = (user) => {
    subscription.value = true;
    return axios.post(route('api.users.subscription', {user}));
  };

  const unfollow = (user) => {
    subscription.value = false;
    return axios.delete(route('api.users.subscription', {user}));
  };

  return {
    subscription, follow, unfollow,
  };
}

export default useSubscription;
