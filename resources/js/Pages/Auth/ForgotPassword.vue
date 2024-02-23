<script setup>
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import {Head, useForm} from '@inertiajs/vue3';
import AuthLayout from "@/Components/Layouts/AuthLayout.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

defineProps({
  status: {
    type: String,
  },
});

const form = useForm({
  email: '',
});

const submit = () => {
  form.post(route('password.forgot.email'));
};
</script>

<template>
  <AuthLayout>
    <Head :title="$trans('Forgot password')"/>

    <div class="h-full w-full max-w-lg space-y-4 flex flex-col justify-between sm:justify-center">
      <form
        class="p-4 sm:p-6 bg-white space-y-10 space-y-6"
        @submit.prevent="submit"
      >
        <div class="mb-4 text-sm text-gray-600">
          {{ $trans('password_forgot_notice') }}
        </div>

        <div
          v-if="status"
          class="mb-4 font-medium text-sm text-green-600"
        >
          {{ status }}
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

        <div class="flex items-center justify-end mt-4">
          <FilledButton
            color="primary"
            class="w-full !py-4 !text-sm"
            :class="{'opacity-25': form.processing}"
            :disabled="form.processing"
          >
            {{ $trans('Send password reset mail') }}
          </FilledButton>
        </div>
      </form>
    </div>
  </AuthLayout>
</template>
