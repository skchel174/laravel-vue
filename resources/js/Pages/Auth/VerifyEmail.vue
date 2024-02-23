<script setup>
import {computed} from 'vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthLayout from "@/Layouts/AuthLayout.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

const props = defineProps({
  status: {
    type: String,
  },
});

const form = useForm({});

const submit = () => {
  form.get(route('register.email'));
};

const verificationLinkSent = computed(() => {
  return props.status === 'verification-link-sent';
});
</script>

<template>
  <AuthLayout>
    <Head :title="$trans('Email Verification')"/>

    <div class="flex-1 sm:flex-none max-w-lg p-4 sm:p-6 bg-white space-y-10">
      <div class="px-1 text-sm text-gray-600">
        {{ $trans('email_verification_notice') }}
      </div>

      <div
        v-if="verificationLinkSent"
        class="px-1 font-medium text-sm text-green-600"
      >
        {{ $trans('email_verification_sent') }}
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
