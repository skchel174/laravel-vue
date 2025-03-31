<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import FormLabel from '@/Components/FormLabel.vue';
import FormInput from '@/Components/FormInput.vue';
import FormError from '@/Components/FormError.vue';
import ButtonPrimary from "@/Components/ButtonPrimary.vue";

const form = useForm({
  email: '',
  username: '',
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
  <Head title="Registration"/>

  <AuthLayout>
    <form
      class="w-full max-w-sm space-y-4 rounded-lg p-4 sm:border sm:border-gray-300 sm:shadow-lg sm:p-6 sm:py-8 bg-white"
      @submit.prevent="submit"
    >
      <header class="my-12 sm:mb-4 sm:mt-0">
        <h2 class="text-3xl sm:text-xl font-semibold capitalize">Registration</h2>
      </header>

      <div class="space-y-1">
        <FormLabel for="username" value="Username"/>
        <FormInput
          id="username"
          type="text"
          v-model="form.username"
          required
        />
        <FormError :value="form.errors.username"/>
      </div>

      <div class="space-y-1">
        <FormLabel for="email" value="Email"/>
        <FormInput
          id="email"
          type="email"
          placeholder="m@example.com"
          v-model="form.email"
          required
        />
        <FormError :value="form.errors.email"/>
      </div>

      <div class="space-y-1">
        <FormLabel for="password" value="Password"/>
        <FormInput
          id="password"
          type="password"
          v-model="form.password"
          required
        />
        <FormError :value="form.errors.password"/>
      </div>

      <div class="space-y-1">
        <FormLabel for="password_confirmation" value="Confirm password"/>
        <FormInput
          id="password_confirmation"
          type="password"
          v-model="form.password_confirmation"
          required
        />
        <FormError :value="form.errors.password_confirmation"/>
      </div>

      <div class="pt-8 sm:pt-4 flex items-center justify-end flex-col space-y-6">
        <ButtonPrimary
          class="w-full"
          :disabled="form.processing"
        >
          Register
        </ButtonPrimary>
      </div>

      <div class="pt-8 sm:pt-4 flex justify-center">
        <p class="text-sm font-medium text-gray-800">
          Already registered?
          <Link
            href="#"
            class="px-1 border-b border-gray-950 text-gray-950 capitalize"
          >
            Log in
          </Link>
        </p>
      </div>
    </form>
  </AuthLayout>
</template>
