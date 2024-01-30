<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import DangerButton from '@/Components/Buttons/DangerButton.vue';
import SecondaryButton from '@/Components/Buttons/NeutralButton.vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
  password: '',
});

const deleteUser = () => {
  form.delete(route('profile.delete'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  });
};

const openModal = () => {
  confirmingUserDeletion.value = true;
};

const closeModal = () => {
  confirmingUserDeletion.value = false;
  form.reset();
};
</script>

<template>
  <section class="max-w-2xl space-y-6">
    <header class="flex space-x-4">
      <div>
        <div class="h-8 w-8 bg-yellow-700 flex items-center justify-center rounded-sm">
          <span class="material-icons !text-base text-white">
            delete
          </span>
        </div>
      </div>

      <div>
        <h2 class="text-lg font-medium text-gray-900 leading-none">
          {{ $trans('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
          {{ $trans('delete_account_notice') }}
        </p>
      </div>
    </header>

    <DangerButton @click="openModal">
      {{ $trans('Delete Account') }}
    </DangerButton>

    <Modal v-model:open="confirmingUserDeletion">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
          {{ $trans('delete_account_confirmation') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
          {{ $trans('delete_account_notice') }}
        </p>

        <div class="mt-6">
          <InputLabel
            for="password"
            :value="$trans('Password')"
            class="sr-only"
          />

          <TextInput
            id="password"
            ref="passwordInput"
            type="password"
            class="mt-1 block w-3/4"
            placeholder="Password"
            v-model="form.password"
          />

          <InputError
            class="mt-2"
            :message="form.errors.password"
          />
        </div>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click.prevent="closeModal">
            {{ $trans('Cancel') }}
          </SecondaryButton>

          <DangerButton
            class="ms-3"
            :class="{'opacity-25': form.processing}"
            :disabled="form.processing"
            @click.prevent="deleteUser"
          >
            {{ $trans('Delete') }}
          </DangerButton>
        </div>
      </div>
    </Modal>
  </section>
</template>
