<script setup>
import CategoriesMenuLink from "@/Components/AppHeader/CategoriesMenuLink.vue";
</script>

<template>
  <div class="flex flex-col">
    <h3 class="px-6 py-4 uppercase text-sm text-gray-500 font-medium">
      {{ $trans('Categories') }}
    </h3>

    <!--   TODO: add links   -->

    <CategoriesMenuLink
      :href="route('articles.feed')"
      :selected="$page.props.ziggy.location === route('articles.feed')"
    >
      {{ $trans('My feed') }}
    </CategoriesMenuLink>

    <CategoriesMenuLink
      :href="route('articles')"
      :selected="$page.props.ziggy.location === route('articles')"
    >
      {{ $trans('All categories') }}
    </CategoriesMenuLink>

    <CategoriesMenuLink
      v-for="category in $page.props.app.categories"
      :key="category.id"
      href="#"
    >
      <!--   TODO: add localization   -->
      {{ category.name }}
    </CategoriesMenuLink>
  </div>
</template>
