<script setup>
import {computed} from "vue";
import CategoriesMenuLink from "@/Components/AppHeader/CategoriesMenuLink.vue";

const categories = computed(() => {
  return page.props.app.categories.map(category => {
    const url = route('category.articles', {category: category.slug});
    const selected = url === page.props.ziggy.location;

    return {...category, url, selected}
  });
});
</script>

<template>
  <div class="flex flex-col">
    <h3 class="px-6 py-4 uppercase text-sm text-gray-500 font-medium">
      {{ $trans('Categories') }}
    </h3>

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
      v-for="category in categories"
      :key="category.id"
      :href="category.url"
      :selected="category.selected"
    >
      {{ category.name }}
    </CategoriesMenuLink>
  </div>
</template>
