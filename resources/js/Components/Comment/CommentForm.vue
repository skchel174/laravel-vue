<script setup>
import {inject} from "vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/Form/InputLabel.vue";
import InputError from "@/Components/Form/InputError.vue";
import TextareaInput from "@/Components/Form/TextareaInput.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

const props = defineProps({
  articleId: {
    type: Number,
    required: true,
  },
});

const notify = inject('notify');

const form = useForm({
  text: '',
});

const onSubmit = () => {
  const url = route('articles.comment.create', {
    article: props.articleId,
  });

  form.post(url, {
    preserveScroll: true,
    onSuccess: () => {
      notify('success', 'Comment successfully created');
      form.reset();
    },
  });
};
</script>

<template>
  <form
    class="p-4 bg-gray-50 border-t border-gray-200"
    @submit.prevent="onSubmit"
  >
    <InputLabel
      class="!font-bold"
      for="comment_form"
      :value="$trans('Your comment')"
    />

    <TextareaInput
      id="comment_form"
      class="mt-4 w-full block"
      v-model="form.text"
      rows="5"
    />

    <InputError
      class="mt-2"
      :message="form.errors.text"
    />

    <FilledButton
      color="primary"
      class="mt-4"
      :disabled="form.text.length === 0"
    >
      {{ $trans('Send') }}
    </FilledButton>
  </form>
</template>
