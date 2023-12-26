<script setup>
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextareaInput from "@/Components/Form/TextareaInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

const props = defineProps({
  articleId: {
    type: Number,
    required: true,
  },

  commentId: {
    type: Number,
    required: true,
  },

  text: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(['close']);

const form = useForm({
  text: props.text,
});

const sendForm = () => {
  const url = route('articles.comment.update', {
    article: props.articleId,
    comment: props.commentId,
  });

  form.post(url, {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      emit('close');
    },
  });
};
</script>

<template>
  <form
    class="p-4 bg-gray-50 border-t border-gray-200"
    @submit.prevent="sendForm"
  >
    <div class="flex justify-between items-center">
      <InputLabel
        class="!font-bold"
        for="comment_form"
        value="Edit comment"
      />

      <span
        class="material-icons !text-xl text-gray-400 cursor-pointer"
        @click="$emit('close')"
      >
        close
      </span>
    </div>

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
      Save
    </PrimaryButton>
  </form>
</template>
