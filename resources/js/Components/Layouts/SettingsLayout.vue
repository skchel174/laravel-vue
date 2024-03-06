<script setup>
import {Link, router} from "@inertiajs/vue3";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";
import NotificationWrapper from "@/Components/Notification/NotificationWrapper.vue";
</script>

<template>
  <NotificationWrapper>
    <header class="w-full h-24 bg-white flex justify-center border border-gray-200">
      <div class="w-full h-full max-w-6xl px-4 lg:px-6 flex justify-between items-center">
        <div class="text-2xl text-gray-700 space-x-2">
          <Link
            class="font-black"
            :href="route('main')"
          >
            {{ $trans('Feed') }}
          </Link>

          <span>{{ $trans('Account') }}</span>
        </div>

        <div class="hidden md:block space-x-4">
          <Link
            class="text-sm text-gray-700 font-semibold"
            :href="route('user', {user: $page.props.auth.user.login})"
          >
            @{{ $page.props.auth.user.login }}
          </Link>

          <OutlineButton
            class="!py-1.5 !px-5"
            color="primary"
            @click="router.get(route('logout'))"
          >
            {{ $trans('Logout') }}
          </OutlineButton>
        </div>

        <button
          class="block md:hidden h-9 w-9 border border-gray-300 hover:border-sky-675 transition duration-200 rounded flex justify-center items-center cursor-pointer"
          @click="router.get(route('logout'))"
        >
          <MaterialIcon class="!text-xl text-sky-675">
            logout
          </MaterialIcon>
        </button>
      </div>
    </header>

    <main class="flex-1 lg:mt-4 mx-auto w-full max-w-3xl">
      <slot/>
    </main>
  </NotificationWrapper>
</template>
