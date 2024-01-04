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

const avatar = ref(props.avatar);
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
  avatar.value = {thumb: objectUrl, default: objectUrl};
  emit('update:modelValue', file);
};

const resetImage = () => {
  isAvatarUpdated.value = false;
  avatarInput.value.value = '';
  avatar.value = props.avatar;
  emit('update:modelValue', undefined);
};

const deleteImage = () => {
  isAvatarUpdated.value = true;
  avatarInput.value.value = '';
  avatar.value = null;
  emit('update:modelValue', null);
};
</script>

<template>
  <div class="flex flex-row justify-between lg:flex-col lg:justify-start">
    <div class="space-y-2 lg:space-y-4 flex flex-col">
      <InputLabel value="Avatar"/>

      <div class="hidden lg:flex">
        <Avatar
          v-if="avatar?.thumb"
          size="lg"
          ref="avatarEl"
          :value="avatar"
        />

        <span v-else class="material-icons w-20 h-20 flex justify-center items-center !text-8xl text-gray-300">
          account_circle
        </span>
      </div>

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
          v-if="avatar?.thumb"
          @click.prevent="deleteImage"
        >
          Delete image
        </DangerOutlineButton>
      </div>
    </div>

    <div class="mt-4 flex lg:hidden">
      <Avatar
        v-if="avatar?.thumb"
        size="lg"
        ref="avatarEl"
        :value="avatar"
      />

      <span v-else class="material-icons w-20 h-20 flex justify-center items-center !text-8xl text-gray-300">
        account_circle
      </span>
    </div>

    <input
      ref="avatarInput"
      type="file"
      class="hidden"
      @input="selectImage"
    >
  </div>
</template>
