<script setup>
import {ref} from "vue";
import TextareaInput from "@/Components/Form/TextareaInput.vue";
import InputLength from "@/Components/Form/InputLength.vue";

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
});

defineEmits(['update:content']);

const focus = ref(false);
</script>

<template>
  <div>
    <TextareaInput
      id="title"
      class="!px-0 !border-none !shadow-none !ring-0 !text-3xl !font-black"
      :placeholder="$trans('Title')"
      :model-value="title"
      @update:modelValue="(value) => $emit('update:content', value)"
      @focus="() => focus = true"
      @blur="() => focus = false"
    />

    <div class="h-6 flex justify-end items-top">
      <InputLength
        :visible="focus"
        :input="title"
        :max-length="100"
      />
    </div>
  </div>
</template>
