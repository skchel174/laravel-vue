<script setup>
import {ref} from "vue";
import Avatar from "@/Components/Avatar.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

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

const emit = defineEmits(['update:modelValue']);

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
    <div class="space-y-2 lg:space-y-3 flex flex-col">
      <InputLabel :value="$trans('Avatar')"/>

      <Avatar
        class="hidden lg:flex"
        ref="avatarEl"
        :src="avatar"
        size="lg"
      />

      <p class="w-36 text-xs text-gray-500 font-medium">
        {{$trans('avatar_rules')}}
      </p>

      <InputError :message="error"/>

      <FilledButton
        v-if="isAvatarUpdated"
        color="light"
        class="w-full flex flex-col space-y-1.5"
        @click.prevent="resetImage"
      >
        {{ $trans('Reset') }}
      </FilledButton>

      <div
        v-else
        class="flex lg:flex-col space-x-2 lg:space-x-0 lg:space-y-1.5"
      >
        <FilledButton
          color="light"
          @click.prevent="triggerInput"
        >
          {{ $trans('Select') }}
        </FilledButton>

        <OutlineButton
          v-if="avatar"
          color="danger"
          @click.prevent="deleteImage"
        >
          {{ $trans('Delete') }}
        </OutlineButton>
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
