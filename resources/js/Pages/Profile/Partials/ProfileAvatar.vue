<script setup>
import {ref} from "vue";
import Avatar from "@/Components/Avatar.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import NeutralButton from "@/Components/Buttons/NeutralButton.vue";
import DangerOutlineButton from "@/Components/Buttons/DangerOutlineButton.vue";

const props = defineProps({
  avatar: {
    type: Object,
  },

  modelValue: {
    type: Object,
  },

  error: {
    type: String,
  }
});

const emit = defineEmits([
  'update:modelValue',
]);

const image = ref(props.avatar);
const avatarEl = ref(null);
const avatarInput = ref(null);
const isAvatarUpdated = ref(false);

const triggerInput = () => {
  avatarInput.value.click();
};

const selectImage = () => {
  isAvatarUpdated.value = true;
  const file = avatarInput.value.files[0];
  const objectUrl = URL.createObjectURL(file);
  image.value = {sm: objectUrl, md: objectUrl, xl: objectUrl};
  emit('update:modelValue', file);
};

const resetImage = () => {
  isAvatarUpdated.value = false;
  avatarInput.value.value = '';
  image.value = props.avatar;
  emit('update:modelValue', undefined);
};

const deleteImage = () => {
  isAvatarUpdated.value = true;
  avatarInput.value.value = '';
  image.value = null;
  emit('update:modelValue', null);
};
</script>

<template>
  <div class="flex flex-row justify-between lg:flex-col lg:justify-start">
    <div class="space-y-2 lg:space-y-4 flex flex-col">
      <InputLabel value="Avatar"/>

      <Avatar
        class="hidden lg:flex"
        size="lg"
        ref="avatarEl"
        :value="image"
      />

      <p class="text-xs text-gray-400 font-medium">
        Format: jpg, bmp, png.
        <br/>Maximum file size: 10Mb.
      </p>

      <InputError :message="error"/>

      <NeutralButton
        v-if="isAvatarUpdated"
        class="w-full flex flex-col space-y-1.5"
        @click.prevent="resetImage"
      >
        Reset
      </NeutralButton>

      <div
        v-else
        class="flex lg:flex-col space-x-2 lg:space-x-0 lg:space-y-1.5"
      >
        <NeutralButton @click.prevent="triggerInput">
          Select image
        </NeutralButton>

        <DangerOutlineButton
          v-if="avatar"
          @click.prevent="deleteImage"
        >
          Delete image
        </DangerOutlineButton>
      </div>
    </div>

    <Avatar
      class="mt-4 flex lg:hidden"
      size="lg"
      ref="avatarEl"
      :value="image"
    />

    <input
      ref="avatarInput"
      type="file"
      class="hidden"
      @input="selectImage"
    >
  </div>
</template>
