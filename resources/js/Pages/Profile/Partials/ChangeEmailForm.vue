<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

const user = usePage().props.auth.user;

const form = useForm({
  email: user.email,
  password: '',
});

const changeEmail = () => {
  form.patch(route('profile.email.change'), {
    preserveScroll: true,
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <section class="max-w-2xl space-y-6">
    <header class="flex items-center space-x-4">
      <div>
        <div class="h-8 w-8 bg-cyan-600 flex items-center justify-center rounded-sm">
          <span class="material-icons !text-sm text-white">
            email
          </span>
        </div>
      </div>

      <h2 class="text-lg font-medium text-gray-900 leading-none">
        {{ $trans('Change Email') }}
      </h2>
    </header>

    <form
      class="space-y-6"
      @submit.prevent="changeEmail"
    >
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
        />

        <InputError
          class="mt-2"
          :message="form.errors.email"
        />
      </div>

      <div>
        <InputLabel
          for="email_password"
          :value="$trans('Password')"
        />

        <TextInput
          id="email_password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
        />

        <InputError
          class="mt-2"
          :message="form.errors.password"
        />
      </div>

      <FilledButton
        color="primary"
        :disabled="form.processing"
      >
        {{ $trans('Save') }}
      </FilledButton>
    </form>
  </section>
</template>
