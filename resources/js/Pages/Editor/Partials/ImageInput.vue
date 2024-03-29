<script setup>
import {ref} from "vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

const props = defineProps({
  src: {
    type: [String, null],
  },
});

const emit = defineEmits(['update']);

const image = ref(props.src);
const imageEl = ref(null);
const inputEl = ref(null);

const triggerInput = () => {
  inputEl.value.click();
};

const selectImage = () => {
  const file = inputEl.value.files[0];
  image.value = URL.createObjectURL(file);
  emit('update', file);
};

const resetImage = () => {
  inputEl.value.value = '';
  image.value = props.src;
};

const deleteImage = () => {
  inputEl.value.value = '';
  image.value = null;
  emit('update', null);
};

const openFullImage = () => {
  if (props.src.full) {
    window.open(props.src);
  }
};
</script>

<template>
  <div class="space-y-2">
    <InputLabel
      for="image"
      :value="$trans('Image')"
    />

    <div>
      <div
        v-if="image"
        class="relative pb-[50%]"
      >
        <img
          class="absolute w-full h-full aspect-square object-center object-cover cursor-pointer"
          :ref="imageEl"
          :src="image"
          @click="openFullImage"
          alt="img"
        >

        <div class="flex absolute bottom-3 right-3 z-10 space-x-1">
          <FilledButton
            color="light"
            class="!py-1"
            @click.prevent="triggerInput"
          >
            {{ $trans('Change') }}
          </FilledButton>

          <FilledButton
            v-if="src"
            color="light"
            class="!py-1"
            @click.prevent="deleteImage"
          >
            {{ $trans('Delete') }}
          </FilledButton>

          <FilledButton
            v-else
            color="light"
            class="!py-1"
            @click.prevent="resetImage"
          >
            {{ $trans('Reset') }}
          </FilledButton>
        </div>
      </div>

      <div v-else class="relative pb-[50%]">
        <div
          class="absolute w-full h-full text-gray-400 border border-dashed border-gray-400 flex flex-col justify-center items-center cursor-pointer"
          @click="triggerInput"
        >
          <span class="material-icons !text-5xl">
            add_photo_alternate
          </span>

          <p class="font-semibold">
            {{ $trans('Add image') }}
          </p>

          <p class="w-full text-sm font-medium text-center">
            {{ $trans('article_image_rules') }}
          </p>
        </div>
      </div>
    </div>

    <input
      id="image"
      ref="inputEl"
      type="file"
      class="hidden"
      @input="selectImage"
    >
  </div>
</template>
