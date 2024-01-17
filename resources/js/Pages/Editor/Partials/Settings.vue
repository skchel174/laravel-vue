<script setup>
import TagsSelect from "@/Pages/Editor/Partials/TagsSelect.vue";
import SummaryInput from "@/Pages/Editor/Partials/SummaryInput.vue";
import ImageInput from "@/Pages/Editor/Partials/ImageInput.vue";
import TopicsSelect from "@/Pages/Editor/Partials/TopicsSelect.vue";
import DifficultSelect from "@/Pages/Editor/Partials/DifficultSelect.vue";
import PageFooter from "@/Pages/Editor/Partials/PageFooter.vue";
import NeutralButton from "@/Components/Buttons/NeutralButton.vue";
import PrimaryOutlineButton from "@/Components/Buttons/PrimaryOutlineButton.vue";

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
</script>

<template>
  <div class="bg-white">
    <div class="p-4 lg:py-6 lg:px-8 space-y-8">
      <div class="space-y-4">
        <h3 class="text-base sm:text-lg font-medium pb-1 border-b border-gray-200">
          Article settings
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
          Displaying a article in the feed
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
        Back to editor
      </NeutralButton>

      <PrimaryOutlineButton @click="$emit('save', 'submit')">
        Send to moderation
      </PrimaryOutlineButton>
    </PageFooter>
  </div>
</template>
