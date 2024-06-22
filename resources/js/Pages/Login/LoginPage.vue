<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import FormLabel from "@/Components/FormLabel.vue";
import FormInput from "@/Components/FormInput.vue";
import FormError from "@/Components/FormError.vue";

const form = useForm({
  email: '',
  password: '',
});

const login = () => {
  form.post(route('login'));
};
</script>

<template>
  <AuthLayout>
    <Head :title="$trans('Log in')"/>

    <form
      class="max-w-lg w-full bg-color-base rounded-sm px-6 py-8 space-y-4"
      @submit.prevent="login"
    >
      <h1 class="mb-8 text-3xl text-color-dark font-normal">
        {{ $trans('Log in') }}
      </h1>

      <div class="space-y-1.5">
        <FormLabel
          for="email"
          :value="$trans('Email')"
        />

        <FormInput
          id="email"
          type="email"
          v-model="form.email"
          required
        />

        <FormError :message="form.errors.email"/>
      </div>

      <div class="space-y-1.5">
        <FormLabel
          for="password"
          :value="$trans('Password')"
        />

        <FormInput
          id="password"
          type="password"
          v-model="form.password"
          required
        />

        <FormError :message="form.errors.password"/>
      </div>

      <button
        class="!mt-8 w-full py-4 btn btn-primary"
        :class="{'opacity-25': form.processing}"
        :disabled="form.processing"
      >
        {{ $trans('Login') }}
      </button>

      <div>
        <Link
          class="text-sm font-medium text-link"
          :href="route('password.forgot')"
        >
          {{ $trans('Forgot password') }}?
        </Link>
      </div>
    </form>

    <div class="max-w-lg w-full bg-color-base rounded-sm p-6">
      <p class="text-center text-sm text-color-base font-medium space-x-1">
        <span>
          {{ $trans('Have no account yet?') }}
        </span>

        <Link
          class="text-link font-medium"
          :href="route('register')"
        >
          {{ $trans('Register') }}
        </Link>
      </p>
    </div>
  </AuthLayout>
</template>
