<script setup>
import {useForm} from '@inertiajs/vue3';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import FilledButton from "@/Components/Buttons/FilledButton.vue";

const form = useForm({
  password: '',
  current_password: '',
  password_confirmation: '',
});

const updatePassword = () => {
  form.patch(route('profile.password.change'), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {
      if (form.errors.password) {
        form.reset('password', 'password_confirmation');
      }
      if (form.errors.current_password) {
        form.reset('current_password');
      }
    },
  });
};
</script>

<template>
  <section class="max-w-2xl space-y-6">
    <header class="flex items-center space-x-4">
      <div class="h-8 w-8 bg-teal-500 flex items-center justify-center rounded-sm">
        <span class="material-icons !text-sm text-white">
          lock
        </span>
      </div>

      <h2 class="text-lg font-medium text-gray-900 leading-none">
        {{ $trans('Update Password') }}
      </h2>
    </header>

    <form
      class="space-y-6"
      @submit.prevent="updatePassword"
    >
      <div>
        <InputLabel
          for="current_password"
          :value="$trans('Current password')"
        />

        <TextInput
          id="current_password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.current_password"
        />

        <InputError
          class="mt-2"
          :message="form.errors.current_password"
        />
      </div>

      <div>
        <InputLabel
          for="password"
          :value="$trans('New password')"
        />

        <TextInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
        />

        <InputError
          class="mt-2"
          :message="form.errors.password"
        />
      </div>

      <div>
        <InputLabel
          for="password_confirmation"
          :value="$trans('Password confirmation')"
        />

        <TextInput
          id="password_confirmation"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password_confirmation"
        />

        <InputError
          class="mt-2"
          :message="form.errors.password_confirmation"
        />
      </div>

      <FilledButton
        color="primary"
        :disabled="form.processing"
      >
        {{ $trans('Save') }}
      </FilledButton>
    </form>
  </section>
</template>
