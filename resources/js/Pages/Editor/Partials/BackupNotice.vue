<script setup>
const props = defineProps({
  visible: {
    type: Boolean,
    required: true,
  },

  backup: {
    type: Object,
    required: true,
  },
});

defineEmits(['update:visible', 'backup']);
</script>

<template>
  <div
    v-if="visible"
    class="relative p-4 flex items-center bg-sky-50 border border-sky-500 text-sm text-gray-700 space-x-4"
  >
    <span class="material-icons !text-[1.75rem] text-sky-600">
      error
    </span>

    <p class="text-sm text-gray-500">
      You have a backup save "{{ backup.title ? backup.title : 'Untitled' }}" at

      <span class="ml-1 font-semibold">
        {{ $formatDate(backup.save_date) }}
      </span>

      <span
        class="ml-2 font-bold tracking-wide text-sky-600 hover:text-sky-400 transition duration-300 cursor-pointer"
        @click="$emit('backup')"
      >
        Restore
      </span>
    </p>

    <span
      class="material-icons absolute top-0.5 right-1.5 !text-xl text-sky-600 hover:text-sky-500 transition duration-300 cursor-pointer"
      @click="$emit('update:visible', false)"
    >
      close
    </span>
  </div>
</template>
