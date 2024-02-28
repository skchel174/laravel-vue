<script setup>
import useSubscription from "@/Hooks/useSubscription.js";
import FilledButton from "@/Components/Buttons/FilledButton.vue";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import RotateLoader from 'vue-spinner/src/ClipLoader.vue'

const props = defineProps({
  topic: {
    type: Object,
    required: true,
  },

  subscription: {
    type: Boolean,
    required: true,
  },
});

const {
  loading,
  subscription,
  subscribe,
  unsubscribe,
} = useSubscription(props.subscription);
</script>

<template>
  <header class="bg-white p-4 pb-8 space-y-4">
    <div class="flex justify-between">
      <div class="flex items-center space-x-6">
        <img
          class="h-12 w-12"
          :src="topic.icon"
          :alt="topic.slug"
        >

        <div class="flex space-x-4">
          <div class="flex flex-col items-center">
            <p class="text-base text-pink-600/75 font-semibold">
              {{ $formatCount(topic.articles_count) }}
            </p>

            <p class="text-xs text-gray-400 capitalize">
              {{ $trans('articles') }}
            </p>
          </div>

          <div class="flex flex-col items-center">
            <p class="text-base text-gray-700 font-semibold">
              {{ $formatCount(topic.subscribers_count) }}
            </p>

            <p class="text-xs text-gray-400 capitalize">
              {{ $trans('subscribers') }}
            </p>
          </div>
        </div>
      </div>

      <div v-if="$page.props.auth.user">
        <FilledButton
          v-if="subscription"
          color="success"
          class="sm:ml-2 h-7 w-32"
          @click="unsubscribe(route('api.topics.subscription', {topic: topic.id}))"
          :disabled="loading"
        >
          {{ $trans('Subscribed') }}

          <RotateLoader
            v-if="loading"
            class="ml-2 flex"
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
          class="sm:ml-2 h-7 w-32"
          @click="subscribe(route('api.topics.subscription', {topic: topic.id}))"
          :disabled="loading"
        >
          {{ $trans('Subscribe') }}

          <RotateLoader
            v-if="loading"
            class="ml-2 flex"
            size=".85rem"
            color="#d1d5db"
          />
        </OutlineButton>
      </div>
    </div>

    <div class="space-y-1">
      <h1 class="text-xl text-gray-800 font-semibold">
        {{ topic.name }}
      </h1>

      <p class="text-sm text-gray-700">
        {{ topic.description }}
      </p>
    </div>
  </header>
</template>
