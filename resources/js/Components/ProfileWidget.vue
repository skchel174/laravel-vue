<script setup>
import {Link} from "@inertiajs/vue3";
import Avatar from "@/Components/Avatar.vue";
import NeutralButton from "@/Components/Buttons/NeutralButton.vue";
import SuccessButton from "@/Components/Buttons/SuccessButton.vue";
import SuccessOutlineButton from "@/Components/Buttons/SuccessOutlineButton.vue";
import useSubscription from "@/Hooks/User/useSubscription.js";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },

  auth: {
    type: Object,
    required: true,
  },

  subscription: {
    type: Boolean,
    required: true,
  }
});

const {subscription, follow, unfollow} = useSubscription(props.subscription);
</script>

<template>
  <div class="p-4 flex flex-col sm:flex-row bg-white">
    <div class="flex-1 mb-2 sm:mb-0">
      <Avatar
        size="md"
        :value="user.avatar"
        clickable
      />

      <h3 class="mt-2 text-base sm:text-lg">
        <span
          class="text-gray-800 font-black"
          v-if="user.name"
        >
          {{ user.name }}
        </span>

        <Link
          class="text-sky-600"
          :href="route('user', {user: user.login})"
        >
          @{{ user.login }}
        </Link>
      </h3>

      <p class="mt-1 text-sm text-gray-500 font-medium capitalize">
        {{ user.about ?? 'user' }}
      </p>
    </div>

    <div
      class="flex justify-start sm:flex-row-reverse"
      v-if="auth.user && auth.user.id !== user.id"
    >
      <SuccessButton
        class="sm:ml-2 h-7 !px-10"
        v-if="subscription"
        @click="() => unfollow(user.id)"
      >
        Following
      </SuccessButton>

      <SuccessOutlineButton
        class="sm:ml-2 h-7 !px-10"
        @click="() => follow(user.id)"
        v-else
      >
        Follow
      </SuccessOutlineButton>

      <NeutralButton class="ml-2 sm:ml-0 h-7 w-7">
        <span class="material-icons !text-lg text-gray-400">
          email
        </span>
      </NeutralButton>
    </div>
  </div>
</template>
