<script setup>
import {inject, ref} from "vue";
import ImageUploader from "quill-image-uploader";
import BlotFormatter from 'quill-blot-formatter';
import PageFooter from "@/Pages/Editor/Partials/PageFooter.vue";
import TitleInput from "@/Pages/Editor/Partials/TitleInput.vue";
import ArticleAuthor from "@/Pages/Editor/Partials/Author.vue"
import ArticleEditorToolbar from "@/Pages/Editor/Partials/EditorToolbar.vue";
import PrimaryOutlineButton from "@/Components/Buttons/PrimaryOutlineButton.vue";
import {Quill, QuillEditor} from "@vueup/vue-quill";
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import 'quill-image-uploader/dist/quill.imageUploader.min.css';

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

const focus = ref(false);

const showNotification = inject('showNotification');

const saveImage = async (file) => {
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
  scrollingContainer: 'html',
};

const modules = [
  {
    name: 'imageUploader',
    module: ImageUploader,
    options: {
      upload: saveImage,
    },
  },
  {
    name: 'blotFormatter',
    module: BlotFormatter,
  },
];
</script>

<template>
  <div class="flex-1 flex flex-col">
    <header class="p-4 lg:px-8 bg-white">
      <h1 class="font-semibold text-2xl text-gray-800">
        Article editor
      </h1>
    </header>

    <div class="mt-4 p-4 lg:py-6 lg:px-8 flex-1 bg-white">
      <ArticleAuthor
        class="mb-2 lg:mb-4"
        :publish-date="article?.publish_date"
      />

      <TitleInput
        :title="form.title"
        :error="form.errors.title"
        @update="(value) => $emit('updateForm', 'title', value)"
      />

      <QuillEditor
        toolbar="#toolbar"
        class="!w-full !h-auto !border-0 !text-lg"
        content-type="html"
        placeholder="Write article"
        :options="options"
        :modules="modules"
        :content="form.text"
        @update:content="(value) => $emit('updateForm', 'text', value)"
        @focus="() => focus = true"
        @blur="() => focus = false"
      />
    </div>

    <ArticleEditorToolbar
      id="toolbar"
      :visible="focus"
    />

    <div
      v-if="!focus"
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
