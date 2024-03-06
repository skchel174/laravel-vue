<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import FilledButton from "@/Components/Buttons/FilledButton.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

const passwordInput = ref(null);

const confirmingUserDeletion = ref(false);

const form = useForm({
  password: '',
});

const deleteUser = () => {
  form.delete(route('settings.account.delete'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
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
  <section class="p-4 bg-white space-y-6">
    <header class="flex space-x-4">
      <div>
        <div class="h-8 w-8 bg-red-775 flex items-center justify-center rounded-sm">
          <MaterialIcon class="!text-base text-white">
            delete
          </MaterialIcon>
        </div>
      </div>

      <div>
        <h2 class="text-base font-medium text-gray-700 leading-none">
          {{ $trans('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500">
          {{ $trans('delete_account_notice') }}
        </p>
      </div>
    </header>

    <FilledButton
      color="danger"
      @click="openModal"
    >
      {{ $trans('Delete Account') }}
    </FilledButton>

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
            :placeholder="$trans('Password')"
            v-model="form.password"
          />

          <InputError
            class="mt-2"
            :message="form.errors.password"
          />
        </div>

        <div class="mt-6 flex justify-end">
          <FilledButton
            color="secondary"
            @click.prevent="closeModal"
          >
            {{ $trans('Cancel') }}
          </FilledButton>

          <FilledButton
            color="danger"
            class="ms-3"
            :class="{'opacity-25': form.processing}"
            :disabled="form.processing"
            @click.prevent="deleteUser"
          >
            {{ $trans('Delete') }}
          </FilledButton>
        </div>
      </div>
    </Modal>
  </section>
</template>
