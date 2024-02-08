<script setup>
import CategoriesNavLink from "@/Components/AppHeader/CategoriesNavLink.vue";
</script>

<template>
  <div class="w-full flex justify-between lg:justify-start lg:space-x-4">

    <!--   TODO: add links   -->

    <CategoriesNavLink
      :href="route('articles.feed')"
      :selected="$page.props.ziggy.location === route('articles.feed')"
    >
      {{ $trans('My feed') }}
    </CategoriesNavLink>

    <CategoriesNavLink
      :href="route('articles')"
      :selected="$page.props.ziggy.location === route('articles')"
    >
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
