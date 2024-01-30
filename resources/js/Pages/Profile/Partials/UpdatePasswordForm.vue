<script setup>
import {useForm} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

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
  <section class="max-w-2xl">
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
      class="mt-8 space-y-6"
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

      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">
          {{ $trans('Save') }}
        </PrimaryButton>

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p
            v-if="form.recentlySuccessful"
            class="text-sm text-gray-600"
          >
            {{ $trans('Password saved') }}
          </p>
        </Transition>
      </div>
    </form>
  </section>
</template>
