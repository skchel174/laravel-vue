<script setup>
import {Link} from "@inertiajs/vue3";
import NotificationWrapper from "@/Components/Notification/NotificationWrapper.vue";
</script>

<template>
  <NotificationWrapper>
    <div class="h-full flex flex-col bg-white sm:bg-gray-100">
      <header class="py-8 sm:p-4 flex justify-center sm:justify-start bg-white sm:border-b border-gray-200">
        <Link
          class="text-3xl sm:text-4xl font-black capitalize"
          :href="route('main')"
        >
          {{ $trans('Feed') }}
        </Link>
      </header>

      <div class="w-full flex-1 flex flex-col justify-center items-center">
        <slot/>
      </div>
    </div>
  </NotificationWrapper>
</template>
