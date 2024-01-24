<script setup>
import {inject, ref} from "vue";
import ImageUploader from "quill-image-uploader";
import BlotFormatter from 'quill-blot-formatter';
import PageFooter from "@/Pages/Editor/Partials/PageFooter.vue";
import ArticleAuthor from "@/Pages/Editor/Partials/Author.vue"
import ArticleEditorToolbar from "@/Pages/Editor/Partials/EditorToolbar.vue";
import PrimaryOutlineButton from "@/Components/Buttons/PrimaryOutlineButton.vue";
import TextareaInput from "@/Components/Form/TextareaInput.vue";
import InputLength from "@/Components/Form/InputLength.vue";
import {Quill, QuillEditor} from "@vueup/vue-quill";
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import 'quill-image-uploader/dist/quill.imageUploader.min.css';

Quill.debug('error');
Quill.register("modules/imageUploader", ImageUploader);
Quill.register('modules/blotFormatter', BlotFormatter);

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

const titleFocused = ref(false);

const textFocus = ref(false);

const showNotification = inject('showNotification');

const uploadImage = async (file) => {
  try {
    if (!props.form.media) {
      const response = await axios.post(route('api.article.media'));
      emit('updateForm', 'media', response.data.media);
    }

    const uri = route('api.article.media.image', {
      media: props.form.media,
    });

    const data = new FormData();
    data.append('image', file, file.name);

    const response = await axios.post(uri, data, {
      headers: {'Content-Type': 'multipart/form-data'},
    });

    return response.data.image.md;
  } catch (error) {
    // TODO: added api errors handler
    showNotification('error', error.message);
  }
}

const options = {
  debug: 'error',
  placeholder: 'Write article',
  scrollingContainer: 'html',
};

const modules = [
  {
    name: 'imageUploader',
    module: ImageUploader,
    options: {upload: uploadImage},
  },
  {
    name: 'blotFormatter',
    module: BlotFormatter,
  },
];
</script>

<template>
  <div class="flex-1 flex flex-col">
    <div class="p-4 lg:py-6 lg:px-8 flex-1 bg-white">
      <ArticleAuthor
        class="mb-2 lg:mb-4"
        :publish-date="article?.publish_date"
      />

      <div>
        <TextareaInput
          id="title"
          class="!px-0 !border-none !shadow-none !ring-0 !text-3xl !font-black"
          placeholder="Title"
          :model-value="form.title"
          @update:modelValue="value => $emit('updateForm', 'title', value)"
          @focus="() => titleFocused = true"
          @blur="() => titleFocused = false"
        />

        <div class="h-6 flex justify-end items-top">
          <InputLength
            :visible="titleFocused"
            :input="form.title"
            :max-length="100"
          />
        </div>
      </div>

      <QuillEditor
        toolbar="#toolbar"
        class="!w-full !h-auto !border-0 !text-lg"
        content-type="html"
        :options="options"
        :modules="modules"
        :content="form.text"
        @update:content="(value) => $emit('updateForm', 'text', value)"
        @focus="() => textFocus = true"
        @blur="() => textFocus = false"
      />
    </div>

    <ArticleEditorToolbar
      id="toolbar"
      :visible="textFocus"
    />

    <div
      v-if="!textFocus"
      class="bg-white h-10"
    />

    <PageFooter class="justify-end">
      <PrimaryOutlineButton
        :disabled="form.title.length === 0 || form.text.length < 10"
        @click="$emit('openTab', 'Settings')"
      >
        Proceed to settings
      </PrimaryOutlineButton>
    </PageFooter>
  </div>
</template>

<style>
.ql-editor {
  padding: 0;
  overflow: visible;
  background-color: #ffffff;
}

.ql-editor.ql-editor::before {
  left: 0;
  color: #d1d5db;
  font-size: 1.125rem;
  font-style: normal;
  font-weight: 500;
}
</style>
