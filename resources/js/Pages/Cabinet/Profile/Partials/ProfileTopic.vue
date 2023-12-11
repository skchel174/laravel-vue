<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
import Popover from "@/Components/Popover.vue";
import PrimaryButton from "@/Components/Buttons/SecondaryButton.vue";

defineProps({
  topic: {
    type: Object,
    required: true,
  },
});

defineEmits(['unsubscribe']);

const topicEl = ref(null);

const isPopoverOpen = ref(false);
</script>

<template>
  <div
    ref="topicEl"
    class="mb-2 mr-2 px-2 py-0.5 bg-lime-500/60 rounded-sm cursor-pointer text-sm text-gray-500 font-medium hover:bg-lime-500/80 hover:text-sky-600 transition duration-400 select-none"
    :class="{'text-sky-600 bg-lime-500/80': isPopoverOpen}"
    @click="isPopoverOpen = !isPopoverOpen"
  >
    {{ topic.name }}

    <Popover
      :anchor-el="topicEl"
      v-model:open="isPopoverOpen"
    >
      <div class="w-72">
        <div class="p-4 border-b border-gray-200 space-y-2">
          <img
            class="mb-2 w-14 h-14"
            :src="topic.icon"
            :alt="topic.slug"
          >
          <!-- TODO: set topic route url -->
          <Link
            href="#"
            class="text-base text-sky-600 font-bold hover:text-sky-500 transition"
          >
            {{ topic.name }}
          </Link>

          <p class="text-sm text-gray-500 font-medium break-words">
            {{ topic.description }}
          </p>

          <PrimaryButton @click="$emit('unsubscribe', topic)">
            Unsubscribe
          </PrimaryButton>
        </div>

        <div class="p-4 flex justify-between">
          <div class="text-sm text-gray-500 font-medium">
            Publications:
            <span class="ml-0.5 text-sm text-gray-600 font-medium">
              {{ $formatCount(topic.articles_count) }}
            </span>
          </div>

          <div class="text-sm text-gray-500 font-medium">
            Subscribers:
            <span class="ml-0.5 text-sm text-gray-600 font-medium">
              {{ $formatCount(topic.subscribers_count) }}
            </span>
          </div>
        </div>
      </div>
    </Popover>
  </div>
</template>
