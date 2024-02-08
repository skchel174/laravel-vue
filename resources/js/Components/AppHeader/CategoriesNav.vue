<script setup>
import CategoriesNavLink from "@/Components/AppHeader/CategoriesNavLink.vue";
import {computed} from "vue";
import {usePage} from "@inertiajs/vue3";

const page = usePage();

const categories = computed(() => {
  return page.props.app.categories.map(category => {
    const url = route('category.articles', {category: category.slug});
    const selected = url === page.props.ziggy.location;

    return {...category, url, selected}
  });
});
</script>

<template>
  <div class="w-full flex justify-between lg:justify-start lg:space-x-4">
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
      v-for="category in categories"
      :key="category.id"
      :href="category.url"
      :selected="category.selected"
    >
      {{ category.name }}
    </CategoriesNavLink>
  </div>
</template>
