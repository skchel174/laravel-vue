<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
import Popover from "@/Components/Popover.vue";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";
import useSubscription from "@/Hooks/Topic/useSubscription.js";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

const props = defineProps({
  topic: {
    type: Object,
    required: true,
  },
});

const topicEl = ref(null);

const isPopoverOpen = ref(false);

const {subscribed, subscribe, unsubscribe} = useSubscription(props.topic.is_subscribed)
</script>

<template>
  <div
    ref="topicEl"
    class="mb-2 mr-2 px-2 py-0.5 bg-blue-200 rounded-sm cursor-pointer select-none"
    :class="{'!bg-lime-200': subscribed}"
    @click="isPopoverOpen = !isPopoverOpen"
  >
    <span class="text-sm text-gray-600 font-medium">
      {{ topic.name }}
    </span>

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

          <Link
            :href="route('topic.articles', {topic: topic.slug})"
            class="text-base text-gray-700 font-bold"
          >
            {{ topic.name }}
          </Link>

          <p class="text-sm text-gray-500 font-medium break-words">
            {{ topic.description }}
          </p>

          <div v-if="$page.props.auth.user">
            <FilledButton
              v-if="subscribed"
              color="success"
              @click="unsubscribe(topic.id)"
            >
              {{ $trans('Subscribed') }}
            </FilledButton>

            <OutlineButton
              v-else
              color="success"
              @click="subscribe(topic.id)"
            >
              {{ $trans('Subscribe') }}
            </OutlineButton>
          </div>
        </div>

        <div class="p-4 flex justify-between">
          <div class="text-sm text-gray-500 font-medium">
            <span class="capitalize">
              {{ $trans('Publications') }}:
            </span>
            <span class="ml-0.5 text-sm text-gray-600 font-medium">
              {{ $formatCount(topic.articles_count) }}
            </span>
          </div>

          <div class="text-sm text-gray-500 font-medium">
            <span class="capitalize">
              {{ $trans('Subscribers') }}:
            </span>
            <span class="ml-0.5 text-sm text-gray-600 font-medium">
              {{ $formatCount(topic.subscribers_count) }}
            </span>
          </div>
        </div>
      </div>
    </Popover>
  </div>
</template>
