<script setup>
import {ref, watch} from "vue";
import TextInput from "@/Components/TextInput.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

const props = defineProps({
  value: {
    type: [String, null],
    required: true,
  },
});

const emit = defineEmits(['search']);

const searchInput = ref(props.value);

const timeoutId = ref(null);

watch(searchInput, () => {
  if (searchInput.value === props.value) {
    return;
  }

  if (timeoutId.value) {
    clearTimeout(timeoutId.value);
    timeoutId.value = null;
  }

  timeoutId.value = setTimeout(search, 1500);
});

const search = () => {
  emit('search', searchInput.value.trim());
};
</script>

<template>
  <div class="lg:py-2.5 lg:px-4 bg-white">
    <div class="relative flex w-full">
      <TextInput
        class="w-full h-12 lg:h-10 px-4 border-0 lg:border"
        v-model="searchInput"
        :placeholder="$trans('Search')"
        maxLength="60"
      />

      <button
        class="absolute right-0 h-12 lg:h-10 px-2 flex items-center justify-center"
        @click="search"
      >
        <MaterialIcon clickable class="!text-[1.825rem] bg-white">
          search
        </MaterialIcon>
      </button>
    </div>
  </div>
</template>
