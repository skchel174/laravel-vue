<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import FormLabel from "@/Components/FormLabel.vue";
import FormInput from "@/Components/FormInput.vue";
import FormError from "@/Components/FormError.vue";

const form = useForm({
  email: '',
});

const notify = () => {
  form.post(route('reset-password.notify'));
};
</script>

<template>
  <AuthLayout>
    <Head :title="$trans('Forgot password')"/>

    <form
      class="max-w-lg w-full bg-color-base rounded-sm px-6 py-8 space-y-8"
      @submit.prevent="notify"
    >
      <p class="text-sm font-medium text-color-base">
        {{ $trans('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
      </p>

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

      <button
        class="!mt-8 w-full py-4 btn btn-primary"
        :class="{'opacity-25': form.processing}"
        :disabled="form.processing"
      >
        {{ $trans('Send password reset mail') }}
      </button>
    </form>
  </AuthLayout>
</template>
