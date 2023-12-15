<script setup>
import usePagination from "@/Hooks/usePagination.js";
import PaginationLink from "@/Components/Pagination/PaginationLink.vue";

const props = defineProps({
  currentPage: {
    type: Number,
    required: true,
  },

  totalPages: {
    type: Number,
    required: true,
  },

  routeName: {
    type: String,
    required: true,
  },

  queryParams: {
    type: Object,
    default: () => ({}),
  },
});

const pages = usePagination(props.currentPage, props.totalPages);

</script>

<template>
  <div class="w-full max-w-96 h-12 flex justify-between items-center text-sm font-semibold bg-white">
    <PaginationLink
      :active="currentPage !== 1"
      :href="route(routeName, {'page': currentPage - 1, ...queryParams})"
    >
      <span class="material-icons">chevron_left</span>
      <span class="hidden sm:inline">Prev</span>
    </PaginationLink>

    <div class="h-full flex">
      <PaginationLink
        v-for="page in pages"
        :active="page !== '...'"
        :href="route(routeName, {'page': page, ...queryParams})"
        :class="{'text-sky-600' : page === currentPage}"
      >
        {{ page }}
      </PaginationLink>
    </div>

    <PaginationLink
      :active="currentPage !== totalPages"
      :href="route(routeName, {'page': currentPage + 1, ...queryParams})"
    >
      <div class="hidden sm:inline">Next</div>
      <span class="material-icons">chevron_right</span>
    </PaginationLink>
  </div>
</template>
