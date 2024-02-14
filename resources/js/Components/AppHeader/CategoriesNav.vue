<script setup>
import CategoriesNavLink from "@/Components/AppHeader/CategoriesNavLink.vue";
</script>

<template>
  <div class="w-full flex justify-between lg:justify-start lg:space-x-4">
    <CategoriesNavLink
      v-for="item in $page.props.nav_items"
      :key="item.id"
      :href="item.url"
      :selected="$page.props.nav_location === item.id"
    >
      {{ $trans(item.title) }}
    </CategoriesNavLink>
  </div>
</template>
