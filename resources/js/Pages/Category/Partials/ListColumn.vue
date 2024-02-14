<script setup>
import {computed, ref} from "vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

const props = defineProps({
  title: {
    type: String,
    required: true,
  },

  active: {
    type: Boolean,
    default: false,
  },

  order: {
    type: String,
    validate: value => ['asc', 'desc'].includes(value),
    default: 'desc',
  },

  sortable: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['sort']);

const order = ref(props.order);

const icon = computed(() => {
  return (props.active && order.value === 'asc') ? 'north' : 'south';
});

const sort = () => {
  if (props.sortable) {
    order.value = (order.value === 'asc') ? 'desc' : 'asc';
    emit('sort', order.value);
  }
};
</script>

<template>
  <div
    class="flex items-center"
    :class="{'cursor-pointer': sortable}"
    @click="sort"
  >
    <span
      class="mr-px text-gray-600 text-sm capitalize"
      :class="{'text-sky-700/75': active}"
    >
      {{ $trans(title) }}
    </span>

    <MaterialIcon
      v-if="sortable"
      class="!text-sm"
      :active="active"
    >
      {{ icon }}
    </MaterialIcon>
  </div>
</template>
