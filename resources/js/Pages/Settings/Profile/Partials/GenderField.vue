<script setup>
import OptionsList from "@/Components/Form/Options.vue";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";

defineProps({
  modelValue: {
    type: String,
    required: true,
  },

  error: {
    type: String,
  },
});

defineEmits(['update:modelValue']);
</script>

<template>
<div>
  <div class="flex flex-col space-y-2">
    <InputLabel :value="$trans('Gender')"/>

    <OptionsList
      :model-value="modelValue"
      @update:model-value="value => $emit('update:modelValue', value)"
    >
      <option value="">
        {{ $trans('Not specified') }}
      </option>

      <option value="Male">
        {{ $trans('Male') }}
      </option>

      <option value="Female">
        {{ $trans('Female') }}
      </option>
    </OptionsList>

    <InputError :message="error"/>
  </div>
</div>
</template>
