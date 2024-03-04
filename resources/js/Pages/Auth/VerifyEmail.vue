<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthLayout from "@/Components/Layouts/AuthLayout.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

const form = useForm({});

const submit = () => {
  form.get(route('register.email'));
};
</script>

<template>
  <AuthLayout>
    <Head :title="$trans('Email Verification')"/>

    <div class="flex-1 sm:flex-none max-w-lg p-4 sm:p-6 bg-white space-y-10">
      <div class="px-1 text-sm text-gray-600">
        {{ $trans('email_verification_notice') }}
      </div>

      <form @submit.prevent="submit">
        <div class="mt-4 flex items-center justify-between">
          <FilledButton
            color="primary"
            :class="{'opacity-25': form.processing}"
            :disabled="form.processing"
          >
            {{ $trans('Resend verification email') }}
          </FilledButton>

          <Link
            class="underline text-sm text-gray-600 hover:text-gray-900"
            :href="route('logout')"
          >
            {{ $trans('Logout') }}
          </Link>
        </div>
      </form>
    </div>
  </AuthLayout>
</template>
