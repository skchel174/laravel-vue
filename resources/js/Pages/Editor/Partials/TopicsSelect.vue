<script setup>
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import MultipleSelect from "@/Components/Form/MultipleSelect.vue";

const props = defineProps({
  topics: {
    type: Array,
    required: true,
  },

  value: {
    type: Array,
    required: true,
  },
});

defineEmits(['select']);

const topics = props.topics.map(topic => ({...topic, value: topic.name}));

const selectedTopics = ref(props.value.map(topic => ({...topic, value: topic.name})));

const filteredTopics = ref(topics);

const onInput = (input) => filteredTopics.value = topics.filter(item => {
  return item.value.toLowerCase().search(input.toLowerCase()) !== -1;
});
</script>

<template>
  <div class="space-y-2">
    <InputLabel :value="$trans('Topics')"/>

    <MultipleSelect
      :options="filteredTopics"
      v-model="selectedTopics"
      @input="onInput"
      @update:modelValue="$emit('select', selectedTopics)"
      :placeholder="$trans('Select topics')"
    />
  </div>
</template>
