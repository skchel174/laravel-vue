<script setup>
import {ref} from "vue";
import useMedia from "@/Hooks/useMedia.js";
import Popover from "@/Components/Popover.vue";
import ItemsSelect from "@/Pages/User/Partials/ItemsSelect.vue";
import ItemsSelectButton from "@/Pages/User/Partials/ItemsSelectButton.vue";

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
    <div
      class="relative p-4 bg-white z-10 cursor-pointer"
      @click.stop="() => selectOpen = !selectOpen"
    >
      <ItemsSelectButton
        :current-item="currentLink"
        :open="selectOpen"
      />

      <Popover
        v-if="!isTablet"
        class="top-9 left-3"
        v-model:open="selectOpen"
      >
        <ItemsSelect
          :items="navigation"
          :current-item="currentLink"
          @select="selectLink"
        />
      </Popover>
    </div>

    <TransitionGroup
      enter-from-class="translate-y-[-100%]"
      enter-to-class="translate-y-0"
      enter-active-class="transition-transform duration-500"
      leave-from-class="translate-y-0"
      leave-to-class="translate-y-[-100%]"
      leave-active-class="absolute transition-transform duration-500"
      move-class="transition-transform duration-500"
    >
      <ItemsSelect
        class="w-full !bg-sky-50"
        v-if="isTablet && selectOpen"
        :key="1"
        :items="navigation"
        :current-item="currentLink"
        @select="selectLink"
      />

      <div
        class="mt-4 transition-transform"
        :key="2"
      >
        <slot/>
      </div>
    </TransitionGroup>
  </div>
</template>
