<script setup>
import {ref} from "vue";
import {Link, router} from "@inertiajs/vue3";
import EditIcon from "@/Components/Icons/EditIcon.vue";
import RestoreIcon from "@/Components/Icons/RestoreIcon.vue";
import DeleteIcon from "@/Components/Icons/DeleteIcon.vue";
import Avatar from "@/Components/Avatar.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";

const props = defineProps({
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

const isDeleteModalOpen = ref(false);

const deleteArticle = () => {
  router.delete(route('article.delete', {article: props.articleId}));
  isDeleteModalOpen.value = false;
};
</script>

<template>
  <header class="w-full flex flex-wrap items-center justify-between">
    <div class="order-2 sm:order-1 flex items-center space-x-2">
      <Avatar
        :src="author.avatar"
        size="xs"
      />

      <div class="flex flex-wrap items-center">
        <Link
          class="text-sm text-gray-600 font-semibold !leading-4 mr-2 hover:text-sky-600 transition duration-300"
          :href="route('user', {user: author.login})"
        >
          {{ author.login }}
        </Link>

        <div class="text-xs text-gray-400 font-bold">
          <span v-if="publishDate">
            {{ $formatDate(publishDate, 'MMM D YYYY kk:mm') }}
          </span>

          <span v-else>
            {{ $trans('Never been published') }}
          </span>
        </div>
      </div>
    </div>

    <div
      class="order-1 sm:order-2 w-full sm:w-auto space-x-2 flex justify-end"
      v-if="$page.props.auth.user?.id === author.id"
    >
      <EditIcon
        v-if="status !== 'deleted'"
        @click="router.get(route('article.editor', {article: articleId}))"
      />

      <RestoreIcon
        v-else
        @click="router.patch(route('article.restore', {article: articleId}))"
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

