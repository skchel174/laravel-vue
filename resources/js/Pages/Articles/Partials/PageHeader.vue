<script setup>
import {inject} from "vue";
import SuccessOutlineButton from "@/Components/Buttons/SuccessOutlineButton.vue";

const notify = inject('notify');

const copyRssLink = () => {
  // TODO: add RSS link
  navigator.clipboard.writeText('Demo RSS link');
  notify('success', 'The link was copied to the clipboard');
};
</script>

<template>
  <div class="p-4 sm:px-6 pb-2 bg-white space-y-4">
    <div class="flex justify-between items-center">
      <h1 class="text-xl text-gray-700 font-semibold">
        {{ $trans('My feed') }}
      </h1>

      <!-- TODO: add link to topics subscriptions -->
      <SuccessOutlineButton class="!py-0.5 space-x-2">
        <span class="material-icons !text-xl">
          settings
        </span>

        <span>Subscriptions</span>
      </SuccessOutlineButton>
    </div>

    <div class="flex justify-end">
      <span
        class="material-icons text-gray-400 !text-2xl cursor-pointer"
        @click="copyRssLink"
      >
        rss_feed
      </span>
    </div>
  </div>
</template>
