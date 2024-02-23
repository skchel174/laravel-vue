<script setup>
import {ref} from "vue";
import axios from "axios";
import InputLabel from "@/Components/Form/InputLabel.vue";
import MultipleSelect from "@/Components/Form/MultipleSelect.vue";

const props = defineProps({
  value: {
    type: Array,
    required: true,
  },
});

defineEmits(['select']);

const fetchedTags = ref([]);

const selectedTags = ref(props.value.map(tag => ({...tag, value: tag.name})));

const searchTags = (input) => {
  if (input.length === 0) {
    fetchedTags.value = [];
    return;
  }

  axios.get(route('api.tags.search', {name: input}))
    .then(response => response.data.tags)
    .then(tags => fetchedTags.value = tags.map(tag => ({...tag, value: tag.name})));
};
</script>

<template>
  <div class="space-y-2">
    <InputLabel
      for="tags"
      :value="$trans('Tags')"
    />

    <MultipleSelect
      :options="fetchedTags"
      v-model="selectedTags"
      @input="searchTags"
      @update:modelValue="$emit('select', selectedTags)"
      :placeholder="$trans('Select tags')"
    />
  </div>
</template>
