<script setup>
import {ref} from "vue";
import TitleInput from "@/Pages/Editor/Partials/TitleInput.vue";
import TextInput from "@/Pages/Editor/Partials/TextInput.vue";
import PageFooter from "@/Pages/Editor/Partials/PageFooter.vue";
import ArticleAuthor from "@/Pages/Editor/Partials/Author.vue"
import EditorToolbar from "@/Pages/Editor/Partials/EditorToolbar.vue";
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

const emit = defineEmits(['openTab', 'updateForm']);

const focus = ref(false);
</script>

<template>
  <div class="flex-1 flex flex-col">
    <div class="p-4 lg:py-6 lg:px-8 flex-1 bg-white">
      <ArticleAuthor
        class="mb-2 lg:mb-4"
        :publish-date="article?.publish_date"
      />

      <TitleInput
        :title="form.title"
        @update:content="value => $emit('updateForm', 'title', value)"
      />

      <TextInput
        toolbar="#toolbar"
        :text="form.text"
        @update:content="value => $emit('updateForm', 'text', value)"
        @focus="() => focus = true"
        @blur="() => focus = false"
      />
    </div>

    <EditorToolbar
      id="toolbar"
      :visible="focus"
    />

    <PageFooter class="justify-end">
      <PrimaryOutlineButton
        :disabled="form.title.length === 0 || form.text.length < 10"
        @click="$emit('openTab', 'Settings')"
      >
        {{ $trans('Proceed to settings') }}
      </PrimaryOutlineButton>
    </PageFooter>
  </div>
</template>
