<script setup>
import {usePage} from "@inertiajs/vue3";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

defineProps({
  backup: {
    type: [Object, null],
    required: true,
  },
});

const emit = defineEmits(['restore', 'close']);

const trans = usePage().props.trans;

const restore = () => {
  const confirmation = confirm(trans['article_backup_confirmation']);

  if (confirmation) {
    emit('restore');
    emit('close');
  }
};
</script>

<template>
  <div class="relative p-4 flex items-center bg-sky-50 border border-sky-600/75 text-sm text-gray-700 space-x-4">
    <MaterialIcon class="!text-[1.75rem] !text-sky-700/75">
      error
    </MaterialIcon>

    <p class="text-sm text-gray-500">
      {{ $trans('You have a backup') }}: "{{ backup.title ? backup.title : $trans('Untitled') }}", {{ $trans('saved') }}

      <span class="font-semibold mr-1">
        {{ $formatDate(backup.save_date) }}.
      </span>

      <span
        class="font-bold tracking-wide text-sky-700/75 hover:text-sky-500 transition duration-200 cursor-pointer"
        @click="restore"
      >
        {{ $trans('Restore') }}
      </span>
    </p>

    <MaterialIcon
      class="absolute top-0 right-1 !text-xl !text-sky-700/75 hover:text-sky-500 transition duration-200 cursor-pointer"
      @click="$emit('close')"
    >
      close
    </MaterialIcon>
  </div>
</template>
