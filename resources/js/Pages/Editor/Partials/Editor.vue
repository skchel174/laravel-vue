<script setup>
import {inject, ref} from "vue";
import ImageUploader from "quill-image-uploader";
import BlotFormatter from 'quill-blot-formatter';
import ArticleAuthor from "@/Pages/Editor/Partials/Author.vue"
import TextareaInput from "@/Components/Form/TextareaInput.vue";
import InputLength from "@/Components/Form/InputLength.vue";
import PrimaryOutlineButton from "@/Components/Buttons/PrimaryOutlineButton.vue";
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

    <div
      v-show="textFocus"
      class="sticky bottom-0 h-10 w-full overflow-x-auto border-t border-gray-200 bg-gray-50 z-20 toolbar-container"
    >
      <div class="mx-auto w-full max-w-[64rem] px-2">
        <div id="toolbar" class="w-[26.5rem] !px-0 !border-0">
          <button class="ql-bold"/>
          <button class="ql-italic"/>
          <button class="ql-underline"/>
          <button class="ql-header" value="1"/>
          <button class="ql-header" value="2"/>
          <button class="ql-list" value="ordered"/>
          <button class="ql-list" value="bullet"/>
          <button class="ql-indent" value="-1"/>
          <button class="ql-indent" value="+1"/>
          <button class="ql-blockquote"/>
          <button class="ql-code-block"/>
          <button class="ql-link"/>
          <button class="ql-image"/>
          <button class="ql-video"/>
        </div>
      </div>
    </div>

    <div v-if="!textFocus" class="bg-white h-10"/>

    <div class="h-14 px-4 lg:px-8 flex items-center justify-end bg-white border-t border-gray-200">
      <PrimaryOutlineButton
        :disabled="form.title.length === 0 || form.text.length < 10"
        @click="$emit('openTab', 'Settings')"
      >
        Proceed to settings
      </PrimaryOutlineButton>
    </div>
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

.toolbar-container::-webkit-scrollbar {
  width: 0;
  height: 0;
}
</style>
