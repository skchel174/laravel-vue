<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import EditIcon from "@/Components/Icons/EditIcon.vue";
import RestoreIcon from "@/Components/Icons/RestoreIcon.vue";
import DeleteIcon from "@/Components/Icons/DeleteIcon.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import ArticleAuthor from "@/Components/Article/ArticleAuthor.vue";

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },
});

const isDeleteModalOpen = ref(false);

const deleteArticle = () => {
  router.delete(route('article.delete', {
    article: props.article.id,
  }));

  isDeleteModalOpen.value = false;
};
</script>

<template>
  <header class="w-full flex flex-wrap items-center justify-between">
    <ArticleAuthor
      class="order-2 sm:order-1"
      :author="article.author"
      :publish-date="article.published_at"
    />

    <div
      class="order-1 sm:order-2 w-full sm:w-auto space-x-2 flex justify-end"
      v-if="$page.props.auth.user?.id === article.author.id"
    >
      <EditIcon
        v-if="article.status !== 'deleted'"
        @click="router.get(route('article.editor', {article: article.id}))"
      />

      <RestoreIcon
        v-else
        @click="router.patch(route('article.restore', {article: article.id}))"
      />

      <DeleteIcon @click="isDeleteModalOpen = true"/>

      <Modal
        v-model:open="isDeleteModalOpen"
        max-width="md"
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
            <SecondaryButton @click="isDeleteModalOpen = false">
              Cancel
            </SecondaryButton>

            <DangerButton @click="deleteArticle">
              Delete
            </DangerButton>
          </div>
        </div>
      </Modal>
    </div>
  </header>
</template>

