<script setup>
import CategoriesNavLink from "@/Components/AppHeader/CategoriesNavLink.vue";
</script>

<template>
  <div class="w-full flex justify-between lg:justify-start lg:space-x-8">

    <!--   TODO: add links   -->

    <CategoriesNavLink href="#" selected>
      {{ $trans('My feed') }}
    </CategoriesNavLink>

    <CategoriesNavLink href="#">
      {{ $trans('All categories') }}
    </CategoriesNavLink>

    <CategoriesNavLink
      v-for="category in $page.props.app.categories"
      :key="category.id"
      href="#"
    >
      <!--   TODO: add localization   -->
      {{ category.name }}
    </CategoriesNavLink>
  </div>
</template>
