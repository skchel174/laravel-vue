<script setup>
import {ref} from "vue";
import TagsSelect from "@/Pages/Editor/Partials/TagsSelect.vue";
import SummaryInput from "@/Pages/Editor/Partials/SummaryInput.vue";
import ImageInput from "@/Pages/Editor/Partials/ImageInput.vue";
import TopicsSelect from "@/Pages/Editor/Partials/TopicsSelect.vue";
import DifficultSelect from "@/Pages/Editor/Partials/DifficultSelect.vue";
import PageFooter from "@/Pages/Editor/Partials/PageFooter.vue";
import NeutralButton from "@/Components/Buttons/NeutralButton.vue";
import SuccessButton from "@/Components/Buttons/SuccessButton.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";

const props = defineProps({
  article: {
    type: [Object, null],
    required: true,
  },

  form: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(['openTab', 'updateForm', 'submit']);

const isConfirmationOpen = ref(false);

const sendToModeration = () => {
  emit('updateForm', 'status', 'moderated');
  emit( 'submit');
  isConfirmationOpen.value = false;
};

const saveToDrafts = () => {
  emit('updateForm', 'status', 'draft');
  emit('submit');
  isConfirmationOpen.value = false;
};
</script>

<template>
  <div class="bg-white">
    <div class="p-4 lg:py-6 lg:px-8 space-y-8">
      <div class="space-y-4">
        <h3 class="text-base sm:text-lg font-medium pb-1 border-b border-gray-200">
          {{ $trans('Article Settings') }}
        </h3>

        <TopicsSelect
          :topics="$page.props.topics"
          :value="form.topics"
          @select="(value) => $emit('updateForm', 'topics', value)"
        />

        <TagsSelect
          :value="form.tags"
          @select="(value) => $emit('updateForm', 'tags', value)"
        />

        <DifficultSelect
          :difficulty="$page.props.difficulty"
          :value="form.difficulty"
          @select="value => $emit('updateForm', 'difficulty', value)"
        />
      </div>

      <div class="space-y-4">
        <h3 class="text-base sm:text-lg font-medium pb-1 border-b border-gray-200">
          {{ $trans('Displaying in the feed') }}
        </h3>

        <ImageInput
          :src="article?.image"
          @update="(value) => $emit('updateForm', 'image', value)"
        />

        <SummaryInput
          :model-value="form.summary"
          @update:modelValue="(value) => $emit('updateForm', 'summary', value)"
        />
      </div>
    </div>

    <PageFooter class="justify-between">
      <NeutralButton @click="$emit('openTab', 'Editor')">
        {{ $trans('Back to editor') }}
      </NeutralButton>

      <SuccessButton
        :disabled="form.topics.length === 0"
        @click="() => isConfirmationOpen = true"
      >
        {{ $trans('Save') }}
      </SuccessButton>
    </PageFooter>

    <Modal
      v-model:open="isConfirmationOpen"
      max-width="md"
    >
      <div class="flex flex-col justify-center p-6 space-y-4">
        <h2 class="text-base font-medium text-gray-900">
          {{ $trans('article_save_notice') }}
        </h2>

        <div class="flex justify-start space-x-2">
          <PrimaryButton @click="sendToModeration">
            {{ $trans('Send to moderation') }}
          </PrimaryButton>

          <NeutralButton @click="saveToDrafts">
            {{ $trans('Save to drafts') }}
          </NeutralButton>
        </div>
      </div>

      <span
        class="material-icons absolute top-1 right-2 !text-xl text-gray-600 cursor-pointer"
        @click="() => isConfirmationOpen = false"
      >
        close
      </span>
    </Modal>
  </div>
</template>
