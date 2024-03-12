<script setup>
import {ref} from "vue";
import UserAvatar from "@/Components/UserAvatar.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import InputError from "@/Components/Form/InputError.vue";
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
  <div>
    <InputLabel :value="$trans('Avatar')"/>

    <div class="mt-1 flex justify-between items-start">
      <div>
        <InputError :message="error"/>

        <p class="mb-3 w-44 text-xs text-gray-400 font-medium">
          {{ $trans('avatar_rules') }}
        </p>

        <FilledButton
          v-if="isAvatarUpdated"
          color="light"
          class="w-36 flex flex-col space-y-1.5"
          @click.prevent="resetImage"
        >
          {{ $trans('Reset') }}
        </FilledButton>

        <div v-else class="w-36 flex lg:flex-col space-x-2 lg:space-x-0 lg:space-y-1.5">
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

      <UserAvatar
        ref="avatarEl"
        :src="avatar"
        size="lg"
      />
    </div>

    <input
      ref="avatarInput"
      type="file"
      class="hidden"
      @input="selectImage"
    >
  </div>
</template>
