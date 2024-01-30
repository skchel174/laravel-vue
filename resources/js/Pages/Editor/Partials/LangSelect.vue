<script setup>
import InputLabel from "@/Components/InputLabel.vue";

defineProps({
  lang: {
    type: String,
    required: true,
  }
});

defineEmits(['select'])
</script>

<template>
  <div class="space-y-2">
    <div>
      <InputLabel :value="$trans('Language')"/>
    </div>

    <div class="inline-flex shrink-0 border border-gray-300 rounded">
      <div
        class="h-11 w-20 flex justify-center items-center cursor-pointer m-[-1px]"
        :class="{'border border-sky-600 text-sky-600 rounded-l': lang === 'en'}"
        @click="$emit('select', 'en')"
      >
        <span
          class="text-sm text-gray-500 select-none"
          :class="{'text-sky-600': lang === 'en'}"
        >
          {{ $trans('English') }}
        </span>
      </div>

      <div
        class="h-11 w-20 flex justify-center items-center cursor-pointer m-[-1px]"
        :class="{'border border-sky-600 text-sky-600 rounded-r': lang === 'ru'}"
        @click="$emit('select', 'ru')"
      >
        <span
          class="text-sm text-gray-500 select-none"
          :class="{'text-sky-600': lang === 'ru'}"
        >
          {{ $trans('Russian') }}
        </span>
      </div>
    </div>
  </div>
</template>
