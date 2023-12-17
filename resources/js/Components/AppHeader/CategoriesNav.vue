<script setup>
import CategoriesNavLink from "@/Components/AppHeader/CategoriesNavLink.vue";
</script>

<template>
  <div class="w-full flex justify-between lg:justify-start lg:space-x-8">
    <CategoriesNavLink href="#" selected>
      My feed
    </CategoriesNavLink>

    <CategoriesNavLink href="#">
      All categories
    </CategoriesNavLink>

    <CategoriesNavLink
      v-for="category in $page.props.app.categories"
      :key="category.id"
      href="#"
    >
      {{ category.name }}
    </CategoriesNavLink>
  </div>
</template>
