<script setup>
import CategoriesMenuLink from "@/Components/AppHeader/CategoriesMenuLink.vue";
</script>

<template>
  <div class="flex flex-col">
    <h3 class="px-6 py-4 uppercase text-sm text-gray-500 font-medium">
      {{ $trans('Categories') }}
    </h3>

    <CategoriesMenuLink
      v-for="item in $page.props.nav_items"
      :key="item.id"
      :href="item.url"
      :selected="$page.props.nav_location === item.id"
    >
      {{ $trans(item.title) }}
    </CategoriesMenuLink>
  </div>
</template>
