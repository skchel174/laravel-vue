<script setup>
import InputLabel from "@/Components/Form/InputLabel.vue";
import RadioButton from "@/Components/Form/RadioButton.vue";

const props = defineProps({
  difficulty: {
    type: Array,
    required: true,
  },

  value: {
    type: [String, null],
    required: true
  },
});

defineEmits(['select']);
</script>

<template>
  <div class="space-y-4">
    <InputLabel :value="$trans('Difficulty level')"/>

    <div class="flex flex-col sm:flex-row">
      <RadioButton
        id="no-difficult"
        class="mr-6 mb-1"
        :label="$trans('Not selected')"
        :model-value="value === null"
        @update:model-value="$emit('select', null)"
      />

      <RadioButton
        :id="item"
        class="mr-6 mb-1"
        v-for="item in difficulty"
        :key="item"
        :label="$ucfirst($trans(item))"
        :model-value="value === item"
        @update:model-value="$emit('select', item)"
      />
    </div>
  </div>
</template>
