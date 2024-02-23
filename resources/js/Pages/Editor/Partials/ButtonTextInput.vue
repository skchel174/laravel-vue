<script setup>
import TextInput from "@/Components/Form/TextInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import InputLength from "@/Components/Form/InputLength.vue";

defineProps({
  text: {
    type: [String, null],
    required: true,
  },
});

defineEmits(['update:text']);
</script>

<template>
  <div class="flex flex-col space-y-2">
    <div class="flex items-center justify-between">
      <InputLabel
        for="button-text"
        :value="$trans('Read more button text')"
      />

      <InputLength
        :input="text || ''"
        :max-length="30"
      />
    </div>

    <TextInput
      id="button-text"
      max-length="30"
      :placeholder="$trans('Read more')"
      :model-value="text || ''"
      @update:modelValue="value => $emit('update:text', value)"
    />
  </div>
</template>
