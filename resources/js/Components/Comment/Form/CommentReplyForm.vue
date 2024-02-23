<script setup>
import {inject} from "vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextareaInput from "@/Components/Form/TextareaInput.vue";
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

  author: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(['close']);

const notify = inject('notify');

const form = useForm({
  text: '',
});

const onSubmit = () => {
  const url = route('articles.comment.reply', {
    article: props.articleId,
    comment: props.commentId,
  });

  form.post(url, {
    preserveScroll: true,
    onSuccess: () => {
      notify('success', 'Comment successfully created');
      emit('close');
      form.reset();
    }
  });
};
</script>

<template>
  <form
    class="p-4 pt-3 bg-gray-50 border-y border-gray-200"
    @submit.prevent="onSubmit"
  >
    <div class="flex justify-between items-center">
      <InputLabel class="!font-bold">
        {{ $trans('Reply') }}

        <span class="font-medium text-sky-700/75">
          @{{ author.login }}
        </span>
      </InputLabel>

      <MaterialIcon
        class="!text-xl text-gray-400 cursor-pointer"
        @click="$emit('close')"
      >
        close
      </MaterialIcon>
    </div>

    <TextareaInput
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
      {{ $trans('Send') }}
    </PrimaryButton>
  </form>
</template>
