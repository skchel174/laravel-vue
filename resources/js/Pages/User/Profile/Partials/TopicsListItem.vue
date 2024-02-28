<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
import useSubscription from "@/Hooks/useSubscription.js";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import RotateLoader from 'vue-spinner/src/ClipLoader.vue'
import Popover from "@/Components/Popover.vue";

const props = defineProps({
  topic: {
    type: Object,
    required: true,
  },
});

const topicEl = ref(null);

const isPopoverOpen = ref(false);

const {
  loading,
  subscription,
  subscribe,
  unsubscribe,
} = useSubscription(props.topic.is_subscribed)
</script>

<template>
  <div
    ref="topicEl"
    class="mb-2 mr-2 px-2 py-0.5 bg-blue-200 rounded-sm cursor-pointer select-none"
    :class="{'!bg-lime-200': subscription}"
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
              v-if="subscription"
              color="success"
              class="!px-4"
              @click="unsubscribe(route('api.topics.subscription', {topic: topic.id}))"
              :disabled="loading"
            >
              {{ $trans('Subscribed') }}

              <RotateLoader
                v-if="loading"
                class="ml-1.5 flex"
                size=".85rem"
                color="#d1d5db"
              />

              <MaterialIcon
                v-else
                class="ml-1.5 !text-lg !leading-none"
              >
                close
              </MaterialIcon>
            </FilledButton>

            <OutlineButton
              v-else
              color="success"
              @click="subscribe(route('api.topics.subscription', {topic: topic.id}))"
              :disabled="loading"
            >
              {{ $trans('Subscribe') }}

              <RotateLoader
                v-if="loading"
                class="ml-1.5 flex"
                size=".85rem"
                color="#d1d5db"
              />
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
