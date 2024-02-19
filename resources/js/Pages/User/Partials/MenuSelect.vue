<script setup>
import {ref} from "vue";
import useMedia from "@/Hooks/useMedia.js";
import Popover from "@/Components/Popover.vue";
import MenuList from "@/Components/Menu/MenuList.vue";
import MenuItem from "@/Components/Menu/MenuItem.vue";
import ExpandButton from "@/Components/Buttons/ExpandButton.vue";

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },

  selectedItem: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(['select']);

const selectOpen = ref(false);

const selectedItem = ref(props.selectedItem);

const selectStatus = (value) => {
  selectedItem.value = value;
  selectOpen.value = false;
  emit('select', value);
};

const isTablet = useMedia('(max-width: 1024px)');
</script>

<template>
  <div>
    <div class="relative px-4 bg-white">
      <ExpandButton
        class="w-full py-4 text-sm text-gray-500 font-medium capitalize"
        :expand="selectOpen"
        @click.stop="selectOpen = !selectOpen"
      >
        {{ $ucfirst($trans(selectedItem)) }}
      </ExpandButton>

      <Popover
        v-if="!isTablet"
        class="top-10 left-3"
        v-model:open="selectOpen"
      >
        <MenuList>
          <MenuItem
            class="py-2 px-4 text-sm"
            v-for="item in items"
            :key="item"
            :selected="item === selectedItem"
            @click="selectStatus(item)"
          >
            {{ $ucfirst($trans(item)) }}
          </MenuItem>
        </MenuList>
      </Popover>
    </div>

    <MenuList
      class="w-full max-h-0 overflow-hidden !bg-sky-50 transition-[max-height] duration-500"
      :class="{'max-h-96 ease-in': isTablet && selectOpen}"
    >
      <MenuItem
        class="py-2 px-4 text-sm"
        v-for="item in items"
        :key="item"
        :selected="item === selectedItem"
        @click="selectStatus(item)"
      >
        {{ $ucfirst($trans(item)) }}
      </MenuItem>
    </MenuList>
  </div>
</template>
