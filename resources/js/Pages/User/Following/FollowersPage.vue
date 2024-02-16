<script setup>
import UserLayout from "@/Layouts/User/UserLayout.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import UserItem from "@/Pages/User/Following/Partials/UserItem.vue";

const props = defineProps({
  users: {
    type: Object,
    required: true,
  },

  user: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <UserLayout
    :user="user"
    current-tab="followers"
  >
    <div
      class="mt-4"
      v-if="users.items.length > 0"
    >
      <div class="p-4 bg-white space-y-6">
        <UserItem
          class="flex items-center space-x-2"
          v-for="item in users.items"
          :key="item.id"
          :user="item"
        />
      </div>

      <Pagination
        class="mt-4"
        :items="users"
      />
    </div>

    <div v-else class="mt-16 w-full flex flex-col items-center space-y-8 text-base text-gray-400 font-bold">
      {{ $trans('empty_followers') }}
    </div>
  </UserLayout>
</template>
