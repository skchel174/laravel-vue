<script setup>
import EditIcon from "@/Components/Icons/EditIcon.vue";
import RestoreIcon from "@/Components/Icons/RestoreIcon.vue";
import DeleteIcon from "@/Components/Icons/DeleteIcon.vue";
import Avatar from "@/Components/Avatar.vue";

defineProps({
  articleId: {
    type: Number,
    required: true,
  },

  author: {
    type: Object,
    required: true,
  },

  status: {
    type: String,
    required: true,
  },

  publishDate: {
    type: [String, null],
  },
});
</script>

<template>
  <header class="w-full flex flex-wrap items-center justify-between">
    <div class="order-2 sm:order-1 flex items-center space-x-2">
      <Avatar :value="author.avatar"/>

      <div class="flex flex-wrap items-center">
        <p class="text-sm text-gray-600 font-semibold !leading-4 mr-2">
          {{ author.name }}
        </p>

        <p
          class="text-xs text-gray-400 font-bold"
          v-if="publishDate"
        >
          {{ $formatDate(publishDate, 'MMM D YYYY [at] kk:mm') }}
        </p>
      </div>
    </div>

    <div
      class="order-1 sm:order-2 w-full sm:w-auto space-x-2 flex justify-end"
      v-if="$page.props.auth.user?.id === author.id"
    >
      <EditIcon v-if="status !== 'deleted'"/>

      <RestoreIcon v-else/>

      <DeleteIcon/>
    </div>
  </header>
</template>

