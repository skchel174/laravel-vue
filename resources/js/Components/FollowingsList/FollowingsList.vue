<script setup>
import Pagination from "@/Components/Pagination/Pagination.vue";
import FollowingsListItem from "@/Components/FollowingsList/FollowingsListItem.vue";
import nothingHere from 'img/nothing-here.svg';

defineProps({
  users: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div>
    <div v-if="users.items.length > 0">
      <div class="p-4 bg-white space-y-6">
        <FollowingsListItem
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

    <div v-else class="px-4 flex flex-col items-center justify-center">
      <img
        class="mt-10 w-64"
        :src="nothingHere"
        alt="nothing-here"
      />

      <p class="text-sm text-gray-400 font-medium">
        {{  $trans('empty_followings') }}.
      </p>
    </div>
  </div>
</template>
