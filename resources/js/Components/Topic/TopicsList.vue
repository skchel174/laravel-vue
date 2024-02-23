<script setup>
import {Link} from "@inertiajs/vue3";
import nothingHere from 'img/nothing-here.svg';
import TopicsListItem from "@/Components/Topic/TopicsListItem.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

const props = defineProps({
  topics: {
    type: Object,
    required: true,
  },

  sort: {
    type: String,
    required: true,
  },

  order: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(['sort']);

const sortList = (name) => {
  emit('sort', name, props.order === 'asc' ? 'desc' : 'asc');
};
</script>

<template>
  <div
    class="space-y-4"
    v-if="topics.items.length > 0"
  >
    <div class="p-4 pt-1 lg:pt-2 bg-white">
      <div class="pt-2 pb-1 border-b border-gray-200 hidden lg:flex">
        <div
          class="flex-1 flex items-center cursor-pointer"
          @click="sortList('name')"
        >
          <span
            class="mr-px text-gray-600 text-sm capitalize"
            :class="{'text-sky-675': sort === 'name'}"
          >
            {{ $trans('Title') }}
          </span>

          <MaterialIcon
            class="!text-sm"
            :active="sort === 'name'"
          >
            {{ sort === 'name' && order === 'asc' ? 'north' : 'south' }}
          </MaterialIcon>
        </div>

        <div
          class="min-w-[7rem] flex items-center justify-end cursor-pointer"
          @click="sortList('articles_count')"
        >
          <span
            class="mr-px text-gray-600 text-sm capitalize"
            :class="{'text-sky-675': sort === 'name'}"
          >
            {{ $trans('articles') }}
          </span>

          <MaterialIcon
            class="!text-sm"
            :active="sort === 'articles_count'"
          >
            {{ sort === 'articles_count' && order === 'asc' ? 'north' : 'south' }}
          </MaterialIcon>
        </div>

        <div
          class="min-w-[7rem] flex items-center justify-end cursor-pointer"
          @click="sortList('subscribers_count')"
        >
          <span
            class="mr-px text-gray-600 text-sm capitalize"
            :class="{'text-sky-675': sort === 'name'}"
          >
            {{ $trans('Subscribers') }}
          </span>

          <MaterialIcon
            class="!text-sm"
            :active="sort === 'subscribers_count'"
          >
            {{ sort === 'subscribers_count' && order === 'asc' ? 'north' : 'south' }}
          </MaterialIcon>
        </div>
      </div>

      <TopicsListItem
        class="mt-5"
        v-for="topic in topics.items"
        :key="topic.id"
        :topic="topic"
      />
    </div>

    <Pagination :items="topics"/>
  </div>

  <div v-else class="px-4 flex flex-col items-center justify-center">
    <img
      class="mt-10 w-64"
      :src="nothingHere"
      alt="nothing-here"
    />

    <div class="text-sm text-gray-400 font-medium space-x-1">
      <span>{{ $trans('Unfortunately no topics found') }}.</span>

      <!-- TODO: add feedback link -->
      <Link
        class="text-sky-600/75"
        href="#"
      >
        {{ $trans('Suggest a new topic') }}?
      </Link>
    </div>
  </div>
</template>
