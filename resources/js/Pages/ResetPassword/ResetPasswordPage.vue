<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import FormInput from "@/Components/FormInput.vue";
import FormLabel from "@/Components/FormLabel.vue";
import FormError from "@/Components/FormError.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";

const props = defineProps({
  user: {
    type: Number,
    required: true,
  },

  token: {
    type: String,
    required: true,
  },
});

const form = useForm({
  password: '',
  password_confirmation: '',
});

const reset = () => {
  const url = route('password.reset', {
    user: props.user,
    token: props.token,
  });

  form.post(url, {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <AuthLayout>
    <Head :title="$trans('Reset password')"/>

    <form
      class="max-w-lg w-full bg-color-base rounded-sm px-6 py-8 space-y-4"
      @submit.prevent="reset"
    >
      <h1 class="mb-8 text-3xl text-color-dark font-normal">
        {{ $trans('Reset password') }}
      </h1>

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
        {{ $trans('Reset password') }}
      </button>
    </form>
  </AuthLayout>
</template>
