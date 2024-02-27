<script setup>
import {Link} from "@inertiajs/vue3";
import UserAvatar from "@/Components/UserAvatar.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";

defineProps({
  author: {
    type: Object,
    required: true,
  },

  subscription: {
    type: Boolean,
    required: true,
  }
});
</script>

<template>
  <div class="p-4 flex flex-col sm:flex-row bg-white">
    <div class="flex-1 mb-2 sm:mb-0">
      <UserAvatar
        size="md"
        :src="author.avatar"
      />

      <h3 class="mt-2 text-base sm:text-lg">
        <span
          class="text-gray-800 font-black"
          v-if="author.name"
        >
          {{ author.name }}
        </span>

        <Link
          class="text-sky-675"
          :href="route('user', {user: author.login})"
        >
          @{{ author.login }}
        </Link>
      </h3>

      <p class="mt-1 text-sm text-gray-500 font-medium capitalize">
        {{ author.about ?? $trans('User') }}
      </p>
    </div>

    <div
      class="flex justify-start sm:flex-row-reverse"
      v-if="$page.props.auth.user && $page.props.auth.user.id !== author.id"
    >
      <FilledButton
        v-if="subscription"
        color="success"
        class="sm:ml-2 h-7 !px-10"
        @click="unfollow(author.id)"
      >
        {{ $trans('Following') }}
      </FilledButton>

      <OutlineButton
        v-else
        color="success"
        class="sm:ml-2 h-7 !px-10"
        @click="follow(author.id)"
      >
        {{ $trans('Follow') }}
      </OutlineButton>
    </div>
  </div>
</template>
