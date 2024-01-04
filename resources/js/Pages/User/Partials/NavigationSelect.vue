<script setup>
import {ref} from "vue";
import useMedia from "@/Hooks/useMedia.js";
import Popover from "@/Components/Popover.vue";
import MenuList from "@/Components/Menu/MenuList.vue";
import MenuItem from "@/Components/Menu/MenuItem.vue";
import ExpandButton from "@/Components/Buttons/ExpandButton.vue";

const props = defineProps({
  navigation: {
    type: Array,
    required: true,
  },

  currentLink: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(['select']);

const selectOpen = ref(false);

const currentLink = ref(props.currentLink);

const selectLink = (value) => {
  currentLink.value = value;
  selectOpen.value = false;
  emit('select', value);
};

const isTablet = useMedia('(max-width: 1024px)');
</script>

<template>
  <div class="relative">
    <button
      class="relative w-full p-4 bg-white z-10 lg:z-0 cursor-pointer"
      @click.stop="() => selectOpen = !selectOpen"
    >
      <ExpandButton
        class="text-sm text-gray-500 font-medium capitalize"
        :expand="selectOpen"
      >
        {{ currentLink }}
      </ExpandButton>

      <Popover
        v-if="!isTablet"
        class="top-10 left-3"
        v-model:open="selectOpen"
      >
        <MenuList>
          <MenuItem
            class="py-2 px-4 text-sm capitalize"
            v-for="item in navigation"
            :key="item"
            :selected="currentLink === item"
            @click="() => selectLink(item)"
          >
            {{ item }}
          </MenuItem>
        </MenuList>
      </Popover>
    </button>

    <TransitionGroup
      enter-from-class="translate-y-[-100%]"
      enter-to-class="translate-y-0"
      enter-active-class="transition-transform duration-500"
      leave-from-class="translate-y-0"
      leave-to-class="translate-y-[-100%]"
      leave-active-class="absolute transition-transform duration-500"
      move-class="transition-transform duration-500"
    >
      <MenuList
        class="w-full !bg-sky-50"
        v-if="isTablet && selectOpen"
        :key="1"
      >
        <MenuItem
          class="py-2 px-4 text-sm capitalize"
          v-for="item in navigation"
          :key="item"
          :selected="currentLink === item"
          @click="() => selectLink(item)"
        >
          {{ item }}
        </MenuItem>
      </MenuList>

      <div
        class="transition-transform"
        :key="2"
      >
        <slot/>
      </div>
    </TransitionGroup>
  </div>
</template>
