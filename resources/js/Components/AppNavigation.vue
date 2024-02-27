<script setup>
import {Link} from "@inertiajs/vue3";
import UserMenu from "@/Components/UserMenu/UserMenu.vue";
</script>

<template>
  <nav class="hidden sticky top-0 z-20 h-12 md:flex justify-center bg-white border-b border-gray-200">
    <div class="w-full max-w-3xl lg:max-w-6xl px-4 md:px-0 lg:px-6 flex justify-center lg:justify-between">
      <div class="flex-1 flex justify-between items-center lg:justify-start lg:space-x-6">
        <Link
          v-for="item in $page.props.nav_items"
          :key="item.id"
          :href="item.url"
          class="text-sm text-gray-500 font-medium hover:text-sky-775 transition duration-200"
          :class="{'text-sky-675': $page.props.nav_location === item.id}"
        >
          {{ $trans(item.title) }}
        </Link>
      </div>

      <UserMenu class="hidden lg:flex"/>
    </div>
  </nav>
</template>
