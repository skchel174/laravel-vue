<script setup>
import {onMounted, ref, watch} from "vue";
import TextInput from "@/Components/Form/TextInput.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

const props = defineProps({
  value: {
    type: [String, null],
    required: true,
  },

  timeout: {
    type: Number,
    default: 1500,
  },

  placeholder: {
    type: String,
    default: 'Search',
  },
});

const emit = defineEmits(['search']);

const timeoutId = ref(null);

const searchInput = ref(props.value);

const search = () => emit('search', searchInput.value.trim());

watch(searchInput, () => {
  if (searchInput.value === props.value) {
    return;
  }

  if (timeoutId.value) {
    clearTimeout(timeoutId.value);

    timeoutId.value = null;
  }

  timeoutId.value = setTimeout(search, props.timeout);
});
</script>

<template>
  <div class="lg:py-2.5 lg:px-4 bg-white">
    <div class="relative flex w-full">
      <TextInput
        class="w-full h-12 lg:h-10 px-4 border-0 lg:border"
        v-model="searchInput"
        :focus="Boolean(searchInput)"
        :placeholder="$trans(placeholder)"
      />

      <button
        class="absolute right-0 h-12 lg:h-10 px-2 flex items-center justify-center"
        @click="search"
      >
        <MaterialIcon class="!text-2xl text-gray-400 bg-white cursor-pointer">
          search
        </MaterialIcon>
      </button>
    </div>
  </div>
</template>
