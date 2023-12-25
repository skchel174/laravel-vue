<script setup>
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextareaInput from "@/Components/Form/TextareaInput.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

const props = defineProps({
  articleId: {
    type: Number,
    required: true,
  },
});

const form = useForm({
  text: '',
});

const sendForm = () => {
  const url = route('articles.comment.create', {
    article: props.articleId,
  });

  form.post(url, {
    preserveScroll: true,
    onSuccess: () => form.reset(),
  });
};
</script>

<template>
  <form
    class="p-4 bg-gray-50 border-t border-gray-200"
    @submit.prevent="sendForm"
  >
    <InputLabel
      class="!font-bold"
      for="comment_form"
      value="Your comment"
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

    <PrimaryButton class="mt-4">
      Send
    </PrimaryButton>
  </form>
</template>
