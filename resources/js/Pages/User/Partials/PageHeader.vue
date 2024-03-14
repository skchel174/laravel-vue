<script setup>
import {Link, usePage} from "@inertiajs/vue3";
import UserAvatar from "@/Components/UserAvatar.vue";
import useSubscription from "@/Hooks/useSubscription.js";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import RotateLoader from 'vue-spinner/src/ClipLoader.vue'

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

const {
  loading,
  subscription,
  subscribe,
  unsubscribe,
} = useSubscription(props.subscription);
</script>

<template>
  <header class="p-4 flex flex-col sm:flex-row bg-white">
    <div class="flex-1 mb-2 sm:mb-0">
      <UserAvatar
        size="md"
        :avatar="user.avatar"
        :username="user.username"
      />

      <h3 class="mt-2 text-base sm:text-lg">
        <span
          class="text-gray-800 font-black"
          v-if="user.fullname"
        >
          {{ user.fullname }}
        </span>

        <Link
          class="text-sky-675"
          :href="route('user', {user: user.username})"
        >
          @{{ user.username }}
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
        class="sm:ml-2 h-7 w-32 !font-light"
        :disabled="loading"
        @click="unsubscribe(route('api.users.subscription', {user: user.id}))"
      >
        {{ $trans('Following') }}

        <RotateLoader
          v-if="loading"
          class="ml-2 flex"
          size=".85rem"
          color="#d1d5db"
        />

        <MaterialIcon
          v-else
          class="ml-2 !text-base !leading-none"
        >
          close
        </MaterialIcon>
      </FilledButton>

      <OutlineButton
        v-else
        color="success"
        class="sm:ml-2 h-7 w-32 !font-light"
        :disabled="loading"
        @click="subscribe(route('api.users.subscription', {user: user.id}))"
      >
        {{ $trans('Follow') }}

        <RotateLoader
          v-if="loading"
          class="ml-2 flex"
          size=".85rem"
          color="#d1d5db"
        />
      </OutlineButton>
    </div>
  </header>
</template>
