<script setup>
import MenuList from "@/Components/Menu/MenuList.vue";
import MenuItem from "@/Components/Menu/MenuItem.vue";

defineProps({
  items: {
    type: Array,
    required: true,
  },

  currentItem: {
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
      v-for="item in items"
      :key="item"
      :selected="currentItem === item"
      @click="$emit('select', item)"
    >
      {{ item }}
    </MenuItem>
  </MenuList>
</template>

