<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import AuthLayout from "@/Components/Layouts/AuthLayout.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

const props = defineProps({
  token: {
    type: String,
    required: true,
  },
});

const form = useForm({
  token: props.token,
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('password.reset'), {
    // onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <AuthLayout>
    <Head :title="$trans('Password Reset')"/>

    <div class="h-full w-full max-w-lg space-y-4 flex flex-col justify-between sm:justify-center">
      <form
        class="p-4 sm:p-6 bg-white space-y-10 space-y-6"
        @submit.prevent="submit"
      >
        <header class="mb-8 sm:mb-4">
          <h2 class="text-xl font-black">
            {{ $trans('Password Reset') }}
          </h2>
        </header>

        <div class="mt-4">
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

        <div class="mt-4">
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

        <div class="flex items-center justify-end mt-4">
          <FilledButton
            color="primary"
            class="w-full !py-4 !text-sm"
            :class="{'opacity-25': form.processing}"
            :disabled="form.processing"
          >
            {{ $trans('Reset password') }}
          </FilledButton>
        </div>
      </form>
    </div>
  </AuthLayout>
</template>
