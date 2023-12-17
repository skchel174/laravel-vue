<script setup>
import MenuList from "@/Components/Menu/MenuList.vue";
import MenuItem from "@/Components/Menu/MenuItem.vue";

defineProps({
  statuses: {
    type: Array,
    required: true,
  },

  currentStatus: {
    type: String,
    required: true,
  },
});

defineEmits(['select']);
</script>

<template>
  <MenuList>
    <MenuItem
      class="py-2 px-4 text-sm capitalize"
      v-for="status in statuses"
      :key="status"
      :selected="currentStatus === status"
      @click="$emit('select', status)"
    >
      {{ status }}
    </MenuItem>
  </MenuList>
</template>

