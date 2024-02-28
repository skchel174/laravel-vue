<script setup>
import {ref} from "vue";
import ExpandButton from "@/Components/Buttons/ExpandButton.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";
import ArticleFilter from "@/Components/ArticlesList/ArticleFilter.vue";

const emit = defineEmits(['apply']);

const isOpen = ref(false);

const query = new URLSearchParams(window.location.search);

const order = ref(query.has('period') ? 'top' : 'new');
const period = ref(query.get('period') || 'day');
const difficulty = ref(query.get('difficulty') || 'all');

const apply = () => {
  const filters = {};

  if (difficulty.value !== 'all') {
    filters.difficulty = difficulty.value;
  }

  if (order.value === 'top' && period.value !== 'all time') {
    filters.period = period.value;
  }

  emit('apply', filters);
};
</script>

<template>
  <div>
    <div class="px-4 bg-white">
      <ExpandButton
        class="w-full py-4 text-sm text-gray-500 font-medium"
        :expand="isOpen"
        @click="isOpen = !isOpen"
      >
        {{ $trans('Filters') }}
      </ExpandButton>
    </div>

    <div
      class="w-full max-h-0 overflow-hidden bg-stone-50 transition-[max-height] duration-500"
      :class="{'max-h-96 ease-in': isOpen}"
    >
      <div class="p-4 space-y-4">
        <ArticleFilter
          heading="Show first"
          v-model="order"
          :values="['new', 'top']"
        />

        <ArticleFilter
          v-show="order === 'top'"
          heading="Period"
          v-model="period"
          :values="['day', 'week', 'month', 'year', 'all time']"
        />

        <ArticleFilter
          heading="Level of difficulty"
          v-model="difficulty"
          :values="['all', 'ease', 'medium', 'hard']"
        />

        <FilledButton
          color="success"
          class="!mt-8"
          @click="apply"
        >
          {{ $trans('Apply') }}
        </FilledButton>
      </div>
    </div>
  </div>
</template>
