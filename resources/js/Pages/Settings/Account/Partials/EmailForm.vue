<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

const user = usePage().props.auth.user;

const form = useForm({
  email: user.email,
  password: '',
});

const changeEmail = () => {
  form.patch(route('settings.account.email.change'), {
    preserveScroll: true,
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <section class="p-4 bg-white space-y-6">
    <header class="flex items-center space-x-4">
      <div>
        <div class="h-8 w-8 bg-sky-775 flex items-center justify-center rounded-sm">
          <MaterialIcon class="!text-sm text-white">
            email
          </MaterialIcon>
        </div>
      </div>

      <h2 class="text-base font-medium text-gray-700 leading-none">
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
