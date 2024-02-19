<script setup>
import {Link} from "@inertiajs/vue3";
import Avatar from "@/Components/Avatar.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const url = route('user', {user: props.user.login});
</script>

<template>
  <div class="flex items-center space-x-2">
    <Link :href="url">
      <Avatar :src="user.avatar"/>
    </Link>

    <div class="text-sm font-medium">
      <p class="space-x-0.5">
        <Link
          class="text-gray-700 hover:text-sky-700/75 transition duration-200"
          v-if="user.name"
          :href="url"
        >
          {{ user.name }}
        </Link>

        <Link
          class="text-sky-700/75"
          :href="url"
        >
          @{{ user.login }}
        </Link>
      </p>

      <p class="text-gray-500">
        {{ user.about ?? $trans('User') }}
      </p>
    </div>
  </div>
</template>
