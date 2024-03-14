<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import Checkbox from '@/Components/Form/Checkbox.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import AuthLayout from "@/Components/Layouts/AuthLayout.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

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
    <Head :title="$trans('Login')"/>

    <div class="h-full w-full max-w-lg space-y-4 flex flex-col justify-center">
      <form
        class="p-4 sm:p-6 bg-white space-y-10 space-y-6"
        @submit.prevent="submit"
      >
        <header class="mb-8 sm:mb-4">
          <h2 class="text-xl font-black">
            {{ $trans('Login') }}
          </h2>
        </header>

        <div class="space-y-0.5">
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

        <div class="space-y-0.5">
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

        <Checkbox
          id="remember"
          v-model="form.remember"
          :label="$trans('Remember me')"
        />

        <div class="flex flex-col items-start justify-end space-y-4">
          <FilledButton
            color="primary"
            class="w-full !py-4 !text-sm"
            :class="{'opacity-25': form.processing}"
            :disabled="form.processing"
          >
            {{ $trans('Log in') }}
          </FilledButton>

          <Link
            :href="route('password.forgot')"
            class="inline text-sm text-sky-675 hover:text-sky-775 font-medium transition duration-200"
          >
            {{ $trans('Forgot password?') }}
          </Link>
        </div>
      </form>

      <div class="w-full max-w-lg bg-white p-6 flex justify-center">
        <p class="font-medium text-xs sm:text-sm text-gray-600">
          {{ $trans('Have no account yet?') }}

          <Link
            :href="route('register.form')"
            class="ml-1 text-sky-675 hover:text-sky-775 font-semibold transition duration-200"
          >
            {{ $trans('Register') }}
          </Link>
        </p>
      </div>
    </div>
  </AuthLayout>
</template>
