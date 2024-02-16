<script setup>
import usePagination from "@/Hooks/usePagination.js";
import PaginationLink from "@/Components/Pagination/PaginationLink.vue";

const props = defineProps({
  items: {
    type: Object,
    required: true,
  },
});

const pages = usePagination(props.items.currentPage, props.items.totalPages);
</script>

<template>
  <div
    class="w-full px-2 py-2 flex justify-between items-center bg-white"
    v-if="items.totalPages > 1"
  >
    <PaginationLink
      :active="items.currentPage > 1"
      :href="items.path"
      :data="{...items.options, page: items.currentPage - 1}"
    >
      <span class="material-icons">
        chevron_left
      </span>

      <span class="hidden sm:inline">
        {{ $trans('Prev') }}
      </span>
    </PaginationLink>

    <div class="h-full flex space-x-2">
      <PaginationLink
        v-for="page in pages"
        :active="page !== '...'"
        :href="items.path"
        :data="{...items.options, page: page}"
        :class="{'text-sky-600/75' : page === items.currentPage}"
      >
        {{ page }}
      </PaginationLink>
    </div>

    <PaginationLink
      :active="items.currentPage < items.totalPages"
      :href="items.path"
      :data="{...items.options, page: items.currentPage + 1}"
    >
      <div class="hidden sm:inline">
        {{ $trans('Next') }}
      </div>

      <span class="material-icons">
        chevron_right
      </span>
    </PaginationLink>
  </div>
</template>
