<script setup>
import InputLabel from "@/Components/InputLabel.vue";
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
        class="mr-6 mb-1"
        label="Not selected"
        :selected="value === null"
        @select="$emit('select', null)"
      />

      <RadioButton
        class="mr-6 mb-1"
        v-for="item in difficulty"
        :key="item"
        :label="item"
        :selected="value === item"
        @select="$emit('select', item)"
      />
    </div>
  </div>
</template>
