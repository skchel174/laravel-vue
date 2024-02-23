<script setup>
import {ref} from "vue";
import TextareaInput from "@/Components/Form/TextareaInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import InputLength from "@/Components/Form/InputLength.vue";

const props = defineProps({
  modelValue: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(['update:modelValue']);

const focus = ref(false);

const summary = ref(props.modelValue);
</script>

<template>
  <div class="space-y-2">
    <div class="flex justify-between items-center h-4">
      <InputLabel
        for="summary"
        :value="$trans('Summary')"
      />

      <div>
        <InputLength
          :visible="focus"
          :input="summary"
          :max-length="1000"
        />
      </div>
    </div>

    <TextareaInput
      id="summary"
      class="!text-sm"
      rows="10"
      v-model="summary"
      @update:modelValue="$emit('update:modelValue', summary)"
      @focus="focus = true"
      @blur="focus = false"
    />
  </div>
</template>
