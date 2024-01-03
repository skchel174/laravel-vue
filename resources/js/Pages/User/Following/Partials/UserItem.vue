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
      <Avatar :value="user.avatar"/>
    </Link>

    <div class="text-sm font-medium">
      <p class="space-x-0.5">
        <Link
          class="text-gray-700 hover:text-sky-600 transition duration-300"
          v-if="user.name"
          :href="url"
        >
          {{ user.name }}
        </Link>

        <Link
          class="text-sky-600"
          :href="url"
        >
          @{{ user.login }}
        </Link>
      </p>

      <p class="text-gray-500">
        User
      </p>
    </div>
  </div>
</template>
