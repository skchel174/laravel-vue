<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";

const form = useForm({});

const notify = () => {
  form.get(route('register.notify'));
};
</script>

<template>
  <AuthLayout>
    <Head :title="$trans('Verify registration')"/>

    <form
      class="max-w-lg w-full bg-color-base rounded-sm px-6 py-8 space-y-8"
      @submit.prevent="notify"
    >
      <p class="text-sm font-medium text-color-base">
        {{ $trans('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
      </p>

      <div class="flex items-center justify-between">
        <button
          class="py-2.5 btn btn-primary"
          :class="{'opacity-25': form.processing}"
          :disabled="form.processing"
        >
          {{ $trans('Resend verification email') }}
        </button>

        <Link
          class="text-sm font-medium text-link"
          href="#"
        >
          {{ $trans('Logout') }}
        </Link>
      </div>
    </form>
  </AuthLayout>
</template>
