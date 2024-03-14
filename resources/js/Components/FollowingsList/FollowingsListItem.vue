<script setup>
import {Link} from "@inertiajs/vue3";
import UserAvatar from "@/Components/UserAvatar.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const url = route('user', {user: props.user.username});
</script>

<template>
  <div class="flex items-center space-x-2">
    <Link :href="url">
      <UserAvatar
        :avatar="user.avatar"
        :username="user.username"
      />
    </Link>

    <div class="text-sm font-medium">
      <p class="space-x-0.5">
        <Link
          class="text-gray-700 hover:text-sky-775 transition duration-200"
          v-if="user.fullname"
          :href="url"
        >
          {{ user.fullname }}
        </Link>

        <Link
          class="text-sky-675"
          :href="url"
        >
          @{{ user.username }}
        </Link>
      </p>

      <p class="text-gray-500">
        {{ user.about ?? $trans('User') }}
      </p>
    </div>
  </div>
</template>
