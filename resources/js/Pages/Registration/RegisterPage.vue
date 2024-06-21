<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import FormInput from "@/Components/FormInput.vue";
import FormLabel from "@/Components/FormLabel.vue";
import FormError from "@/Components/FormError.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";

const form = useForm({
  username: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const register = () => {
  form.post(route('register'));
};
</script>

<template>
  <Head :title="$trans('Registration')"/>

  <AuthLayout>
    <form
      class="max-w-lg w-full bg-color-base rounded-sm px-6 py-8 space-y-4"
      @submit.prevent="register"
    >
      <h1 class="mb-8 text-3xl text-color-dark font-normal">
        {{ $trans('Registration') }}
      </h1>

      <div class="space-y-1.5">
        <FormLabel
          for="username"
          :value="$trans('Username')"
        />

        <FormInput
          id="username"
          type="text"
          v-model="form.username"
          required
        />

        <FormError :message="form.errors.username"/>
      </div>

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

      <div class="space-y-1.5">
        <FormLabel
          for="password_confirmation"
          :value="$trans('Password confirmation')"
        />

        <FormInput
          id="password_confirmation"
          type="password"
          v-model="form.password_confirmation"
          required
        />

        <FormError :message="form.errors.password_confirmation"/>
      </div>

      <button
        class="!mt-8 w-full py-4 btn btn-primary"
        :class="{'opacity-25': form.processing}"
        :disabled="form.processing"
      >
        {{ $trans('Register') }}
      </button>
    </form>

    <div class="max-w-lg w-full bg-color-base rounded-sm p-6">
      <p class="text-center text-sm text-color-base font-medium">
        <span>
          {{ $trans('Already registered') }}?
        </span>

        <Link
          class="text-link font-medium"
          href="#"
        >
          {{ $trans('Login') }}
        </Link>
      </p>
    </div>
  </AuthLayout>
</template>
