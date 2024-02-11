<script setup>
import TopicListItem from "@/Pages/Category/Topics/Partials/TopicListItem.vue";
import TopicListColumn from "@/Pages/Category/Topics/Partials/TopicListColumn.vue";

defineProps({
  topics: {
    type: Array,
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

defineEmits(['sortList']);
</script>

<template>
  <div class="px-4 pt-2 pb-4 bg-white">
    <div class="pt-2 pb-1 flex border-b border-gray-200">
      <TopicListColumn
        class="flex-1"
        title="Title"
        :order="order"
        :active="sort === 'name'"
        @sort="order => $emit('sortList', 'name', order)"
      />

      <TopicListColumn
        class="min-w-[7rem] justify-end"
        title="articles"
        :order="order"
        :active="sort === 'articles_count'"
        @sort="order => $emit('sortList', 'articles_count', order)"
      />

      <TopicListColumn
        class="min-w-[7rem] justify-end"
        title="Subscribers"
        :order="order"
        :active="sort === 'subscribers_count'"
        @sort="order => $emit('sortList', 'subscribers_count', order)"
      />
    </div>

    <TopicListItem
      class="mt-5"
      v-for="topic in topics"
      :key="topic.id"
      :topic="topic"
    />
  </div>
</template>
