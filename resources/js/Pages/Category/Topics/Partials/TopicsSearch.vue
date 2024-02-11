<script setup>
import {ref} from "vue";
import TextInput from "@/Components/Form/TextInput.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

const props = defineProps({
  value: {
    type: String,
    required: true,
  },
});

defineEmits(['search']);

const value = ref(props.value);
</script>

<template>
  <div class="flex w-full py-2.5 px-4 bg-white">
    <TextInput
      class="w-full !rounded-r-none"
      v-model="value"
      placeholder="Search"
    >
      <template v-slot:after>
        <div
          class="px-2 flex items-center justify-center"
          @click="$emit('search', value)"
        >
          <MaterialIcon clickable class="!text-[1.725rem]">
            search
          </MaterialIcon>
        </div>
      </template>
    </TextInput>
  </div>
</template>
