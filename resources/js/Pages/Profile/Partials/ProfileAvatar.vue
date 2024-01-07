<script setup>
import {ref} from "vue";
import Avatar from "@/Components/Avatar.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import NeutralButton from "@/Components/Buttons/NeutralButton.vue";
import DangerOutlineButton from "@/Components/Buttons/DangerOutlineButton.vue";

const props = defineProps({
  avatar: {
    type: [String, null],
    required: true
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
  avatar.value = URL.createObjectURL(file);
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

      <Avatar
        class="hidden lg:flex"
        ref="avatarEl"
        :src="avatar"
        size="lg"
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
          v-if="avatar?.thumb"
          @click.prevent="deleteImage"
        >
          Delete image
        </DangerOutlineButton>
      </div>
    </div>

    <Avatar
      class="mt-4 flex lg:hidden"
      ref="avatarEl"
      :src="avatar"
      size="lg"
    />

    <input
      ref="avatarInput"
      type="file"
      class="hidden"
      @input="selectImage"
    >
  </div>
</template>
