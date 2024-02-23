<script setup>
import {inject} from "vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextareaInput from "@/Components/Form/TextareaInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

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

const notify = inject('notify');

const form = useForm({
  text: '',
});

const onSubmit = () => {
  const url = route('articles.comment.update', {
    article: props.articleId,
    comment: props.commentId,
  });

  form.patch(url, {
    preserveScroll: true,
    onSuccess: () => {
      notify('success', 'Comment successfully updated');
      emit('close');
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
    <div class="flex justify-between items-center">
      <InputLabel value="Edit comment"/>

      <MaterialIcon
        class="!text-xl text-gray-400 cursor-pointer"
        @click="$emit('close')"
      >
        close
      </MaterialIcon>
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

    <PrimaryButton
      class="mt-4"
      :disabled="form.text.length === 0"
    >
      {{ $trans('Save') }}
    </PrimaryButton>
  </form>
</template>
