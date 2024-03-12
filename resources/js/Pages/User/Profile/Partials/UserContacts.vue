<script setup>
defineProps({
  contacts: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div class="space-y-2">
    <h5 class="text-sm text-gray-700 font-bold">
      {{ $trans('Contact info') }}
    </h5>

    <div class="flex flex-wrap justify-between">
      <a
        class="my-2 w-full sm:w-[calc(50%-8px)] flex items-center space-x-2.5 text-sm text-sky-675 hover:text-sky-600 transition duration-200"
        v-for="contact in contacts"
        :href="contact.value"
        target="_blank"
      >
        <img
          class="h-6 w-6"
          :src="contact.icon"
          alt="img"
        />

        <p>
          {{ contact.name }}: {{ contact.value }}
        </p>
      </a>
    </div>
  </div>
</template>
