<script setup>
import InputLabel from "@/Components/Form/InputLabel.vue";
import InputLength from "@/Components/Form/InputLength.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputError from "@/Components/Form/InputError.vue";

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
    <div class="flex justify-between items-center">
      <!--  TODO: translation for login  -->
      <InputLabel
        for="login"
        value="Login"
      />

      <InputLength
        :input="modelValue"
        :max-length="25"
      />
    </div>

    <TextInput
      id="login"
      type="text"
      class="mt-1 block w-full"
      :model-value="modelValue"
      @update:model-value="value => $emit('update:modelValue', value)"
      required
    />

    <InputError
      class="mt-2"
      :message="error"
    />
  </div>
</template>
