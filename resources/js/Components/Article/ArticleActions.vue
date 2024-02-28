<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import EditIcon from "@/Components/Icons/EditIcon.vue";
import RestoreIcon from "@/Components/Icons/RestoreIcon.vue";
import DeleteIcon from "@/Components/Icons/DeleteIcon.vue";
import Modal from "@/Components/Modal.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

const props = defineProps({
  articleId: {
   type: Number,
   required: true,
  },

  articleStatus: {
    type: String,
    required: true,
  },
});

const isDeleteModalOpen = ref(false);

const deleteArticle = () => {
  router.delete(route('article.delete', {article: props.articleId}));
  isDeleteModalOpen.value = false;
};
</script>

<template>
  <EditIcon
    v-if="articleStatus !== 'deleted'"
    @click="router.get(route('article.editor', {article: articleId}))"
  />

  <RestoreIcon
    v-else
    @click="router.patch(route('article.restore', {article: articleId}))"
  />

  <DeleteIcon @click="isDeleteModalOpen = true"/>

  <Modal
    max-width="md"
    v-model:open="isDeleteModalOpen"
  >
    <div class="p-6">
      <div class="mb-6 space-y-2">
        <p class="text-base text-gray-800 font-medium">
          {{ $trans('Are you sure you want to delete article?') }}
        </p>

        <p class="text-sm text-gray-500">
          {{ $trans('article_delete_confirmation') }}
        </p>
      </div>

      <div class="flex justify-end space-x-2">
        <FilledButton
          color="secondary"
          @click="isDeleteModalOpen = false"
        >
          Cancel
        </FilledButton>

        <FilledButton
          color="danger"
          @click="deleteArticle"
        >
          Delete
        </FilledButton>
      </div>
    </div>
  </Modal>
</template>
