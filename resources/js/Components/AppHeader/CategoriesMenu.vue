<script setup>
import CategoriesMenuLink from "@/Components/AppHeader/CategoriesMenuLink.vue";

defineProps({
  categories: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div class="flex flex-col">
    <h3 class="px-6 py-4 uppercase text-sm text-gray-500 font-medium">
      Categories
    </h3>

    <CategoriesMenuLink href="#" selected>
      My feed
    </CategoriesMenuLink>

    <CategoriesMenuLink href="#">
      All categories
    </CategoriesMenuLink>

    <CategoriesMenuLink
      v-for="category in categories"
      :key="category.id"
      href="#"
    >
      {{ category.name }}
    </CategoriesMenuLink>
  </div>
</template>
