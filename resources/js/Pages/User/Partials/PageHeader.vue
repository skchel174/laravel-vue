<script setup>
import {Link, usePage} from "@inertiajs/vue3";
import Avatar from "@/Components/Avatar.vue";
import useSubscription from "@/Hooks/User/useSubscription.js";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },

  subscription: {
    type: Boolean,
    required: true,
  }
});

const auth = usePage().props.auth;

const {subscription, follow, unfollow} = useSubscription(props.subscription);
</script>

<template>
  <header class="p-4 flex flex-col sm:flex-row bg-white">
    <div class="flex-1 mb-2 sm:mb-0">
      <Avatar
        size="md"
        :src="user.avatar"
      />

      <h3 class="mt-2 text-base sm:text-lg">
        <span
          class="text-gray-800 font-black"
          v-if="user.name"
        >
          {{ user.name }}
        </span>

        <Link
          class="text-sky-700/75"
          :href="route('user', {user: user.login})"
        >
          @{{ user.login }}
        </Link>
      </h3>

      <p class="mt-1 text-sm text-gray-500 font-medium capitalize">
        {{ user.about ?? $trans('User') }}
      </p>
    </div>

    <div
      class="flex justify-start sm:flex-row-reverse"
      v-if="auth.user && auth.user.id !== user.id"
    >
      <FilledButton
        v-if="subscription"
        color="success"
        class="sm:ml-2 h-7 !px-10"
        @click="() => unfollow(user.id)"
      >
        {{ $trans('Following') }}
      </FilledButton>

      <OutlineButton
        v-else
        color="success"
        class="sm:ml-2 h-7 !px-10"
        @click="() => follow(user.id)"
      >
        {{ $trans('Follow') }}
      </OutlineButton>
    </div>
  </header>
</template>
