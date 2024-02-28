<script setup>
import {inject} from "vue";
import {usePage} from "@inertiajs/vue3";
import {Quill, QuillEditor} from "@vueup/vue-quill";
import ImageUploader from "quill-image-uploader";
import BlotFormatter from "quill-blot-formatter";
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import 'quill-image-uploader/dist/quill.imageUploader.min.css';

Quill.debug('error');
Quill.register("modules/imageUploader", ImageUploader);
Quill.register('modules/blotFormatter', BlotFormatter);

defineProps({
  toolbar: {
    type: String,
    required: true,
  },

  text: {
    type: String,
    required: true,
  },
});

defineEmits(['update:content', 'focus', 'blur']);

const notify = inject('notify');

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
    //TODO: added api errors handler
    notify('error', error.message);
  }
}

const page = usePage();

const options = {
  debug: 'error',
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
  <QuillEditor
    class="!w-full !h-auto !border-0 !text-lg"
    content-type="html"
    :toolbar="toolbar"
    :options="options"
    :modules="modules"
    :content="text"
    :placeholder="$trans('Write article')"
    @update:content="value => $emit('update:content', value)"
    @focus="$emit('focus')"
    @blur="$emit('blur')"
  />
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
