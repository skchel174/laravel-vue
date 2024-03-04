<script setup>
import {Link, router} from "@inertiajs/vue3";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";

const props = defineProps({
  status: {
    type: Number,
    required: true,
  },

  message: {
    type: String,
    required: true,
  },

  back: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <header class="p-4 flex justify-center sm:justify-between items-center">
    <Link
      class="text-4xl text-gray-800 font-black capitalize"
      :href="route('main')"
    >
      {{ $trans('Feed') }}
    </Link>
  </header>

  <main class="flex-1 flex flex-col justify-center items-center">
    <div class="max-w-[42rem] w-full px-4 flex flex-col items-center">
      <p class="text-9xl text-gray-300 font-black">
        {{ status }}
      </p>

      <p class="text-xl text-gray-700 font-semibold ">
        {{ message }}
      </p>

      <OutlineButton
        class="mt-4 !px-10"
        @click="router.get(back)"
      >
        {{ $trans('Go back') }}
      </OutlineButton>
    </div>
  </main>
</template>
