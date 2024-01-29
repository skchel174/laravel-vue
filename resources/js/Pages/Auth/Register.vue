<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthLayout from "@/Layouts/AuthLayout.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

const form = useForm({
  login: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <AuthLayout>
    <Head :title="$trans('Registration')"/>

    <div class="h-full w-full max-w-lg space-y-4 flex flex-col justify-between sm:justify-center">
      <form
        class="p-4 sm:p-6 bg-white space-y-10 space-y-6"
        @submit.prevent="submit"
      >
        <header class="mb-8 sm:mb-4">
          <h2 class="text-xl font-black capitalize">
            {{ $trans('Registration') }}
          </h2>
        </header>

        <div>
          <InputLabel
            for="login"
            :value="$trans('Login')"
          />

          <TextInput
            id="login"
            type="text"
            class="mt-1 block w-full"
            v-model="form.login"
            required
          />

          <InputError
            class="mt-2"
            :message="form.errors.login"
          />
        </div>

        <div>
          <InputLabel
            for="email"
            :value="$trans('Email')"
          />

          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
          />

          <InputError
            class="mt-2"
            :message="form.errors.email"
          />
        </div>

        <div>
          <InputLabel
            for="password"
            :value="$trans('Password')"
          />

          <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
          />

          <InputError
            class="mt-2"
            :message="form.errors.password"
          />
        </div>

        <div>
          <InputLabel
            for="password_confirmation"
            :value="$trans('Confirm password')"
          />

          <TextInput
            id="password_confirmation"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password_confirmation"
            required
          />

          <InputError
            class="mt-2"
            :message="form.errors.password_confirmation"
          />
        </div>

        <div class="flex items-center justify-end !mt-12">
          <PrimaryButton
            class="w-full !py-4 !text-sm"
            :class="{'opacity-25': form.processing}"
            :disabled="form.processing"
          >
            {{ $trans('Register') }}
          </PrimaryButton>
        </div>
      </form>

      <div class="w-full max-w-lg bg-white p-6 flex justify-center">
        <p class="font-medium text-xs sm:text-sm text-gray-600">
          {{ $trans('Already registered?') }}

          <Link
            :href="route('login')"
            class="ml-1 text-sky-600 hover:text-sky-700 font-semibold transition duration-200 capitalize"
          >
            {{ $trans('Login') }}
          </Link>
        </p>
      </div>
    </div>
  </AuthLayout>
</template>
