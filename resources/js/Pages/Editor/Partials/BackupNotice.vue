<script setup>
const props = defineProps({
  backup: {
    type: [Object, null],
    required: true,
  },
});

const emit = defineEmits(['restore', 'close']);

const restore = () => {
  const confirmation = confirm('Are you sure you want to restore autosave?');

  if (confirmation) {
    emit('restore');
    emit('close');
  }
};
</script>

<template>
  <div class="relative p-4 flex items-center bg-sky-50 border border-sky-500 text-sm text-gray-700 space-x-4">
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
        @click="restore"
      >
        Restore
      </span>
    </p>

    <span
      class="material-icons absolute top-0.5 right-1.5 !text-xl text-sky-600 hover:text-sky-500 transition duration-300 cursor-pointer"
      @click="$emit('close')"
    >
      close
    </span>
  </div>
</template>
