<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import Sidebar from "@/Components/Sidebar.vue";
import MenuList from "@/Components/Menu/MenuList.vue";
import MenuItem from "@/Components/Menu/MenuItem.vue";
import UserMenu from "@/Components/UserMenu/UserMenu.vue";

const isMenuOpen = ref(false);
</script>

<template>
  <header class="w-full h-12 bg-gray-600 flex justify-center">
    <div class="w-full h-full max-w-3xl lg:max-w-6xl px-4 md:px-0 lg:px-6 flex justify-between">
      <div class="flex items-center">
        <MaterialIcon
          class="md:!hidden mr-3 !text-3xl text-white hover:!text-white cursor-pointer"
          @click="isMenuOpen = !isMenuOpen"
        >
          menu
        </MaterialIcon>

        <Link
          class="text-2xl text-white font-black"
          :href="route('main')"
        >
          {{ $trans('Feed') }}
        </Link>
      </div>

      <UserMenu class="lg:hidden !text-gray-200 hover:[&_span]:!text-gray-200"/>
    </div>

    <Sidebar
      side="left"
      v-model:open="isMenuOpen"
    >
      <div class="flex flex-col">
        <h3 class="px-6 py-4 uppercase text-sm text-gray-500 font-medium">
          {{ $trans('Categories') }}
        </h3>

        <MenuList>
          <Link
            v-for="item in $page.props.nav.items"
            :key="item.id"
            :href="item.url"
          >
            <MenuItem
              class="px-6 py-3.5"
              :selected="$page.props.nav.location === item.id"
            >
              {{ $trans(item.title) }}
            </MenuItem>
          </Link>
        </MenuList>
      </div>
    </Sidebar>
  </header>
</template>
