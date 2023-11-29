<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthLayout from "@/Layouts/AuthLayout.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

defineProps({
  canResetPassword: {
    type: Boolean,
  },

  status: {
    type: String,
  },

  error: {
    type: String,
  },
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <AuthLayout>
    <Head title="Log in"/>

    <div class="h-full w-full max-w-lg space-y-4 flex flex-col justify-between sm:justify-center">
      <form
        class="p-4 sm:p-6 bg-white space-y-10 space-y-6"
        @submit.prevent="submit"
      >
        <header class="mb-8 sm:mb-4">
          <h2 class="text-xl font-black">
            Log in
          </h2>
        </header>

        <div
          v-if="status"
          class="mb-4 font-medium text-sm text-green-600"
        >
          {{ status }}
        </div>

        <div
          v-if="error"
          class="mb-4 font-medium text-sm text-red-600"
        >
          {{ status }}
        </div>

        <div>
          <InputLabel for="email" value="Email"/>

          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
          />

          <InputError class="mt-2" :message="form.errors.email"/>
        </div>

        <div>
          <InputLabel for="password" value="Password"/>

          <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="current-password"
          />

          <InputError class="mt-2" :message="form.errors.password"/>
        </div>

        <div class="inline-block">
          <label class="flex items-center select-none cursor-pointer">
            <Checkbox
              name="remember"
              v-model:checked="form.remember"
            />

            <span class="ms-2 text-sm text-gray-600">
              Remember me
            </span>
          </label>
        </div>

        <div class="flex flex-col items-start justify-end space-y-4">
          <PrimaryButton
            class="w-full !py-4 !text-sm"
            :class="{'opacity-25': form.processing}"
            :disabled="form.processing"
          >
            Log in
          </PrimaryButton>

          <Link
            :href="route('password.forgot')"
            class="inline text-sm text-sky-600 hover:text-sky-700 focus:text-sky-800 font-medium transition duration-200"
          >
            Forgot your password?
          </Link>
        </div>
      </form>

      <div class="w-full max-w-lg bg-white p-6 flex justify-center">
        <p class="font-medium text-xs sm:text-sm text-gray-600">
          Already registered?

          <Link
            :href="route('register.form')"
            class="ml-1 text-sky-600 hover:text-sky-700 font-semibold transition duration-200"
          >
            Register
          </Link>
        </p>
      </div>
    </div>
  </AuthLayout>
</template>
