<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

const user = usePage().props.auth.user;

const form = useForm({
  email: user.email,
  password: '',
});

const updatePassword = () => {
  form.patch(route('profile.email.change'), {
    preserveScroll: true,
    onFinish: () => {
      form.reset('password');
    }
  });
};
</script>

<template>
  <section class="space-y-6">
    <header class="flex items-start space-x-4">
      <div>
        <div class="h-8 w-8 bg-cyan-600 flex items-center justify-center rounded-sm">
          <span class="material-icons !text-sm text-white">
            email
          </span>
        </div>
      </div>

      <div>
        <h2 class="text-lg font-medium text-gray-900 leading-none">
          Change Email
        </h2>

        <p class="mt-1 text-sm text-gray-600">
          The email address will be replaced after confirmation.
        </p>
      </div>
    </header>

    <form
      class="mt-8 space-y-6"
      @submit.prevent="updatePassword"
    >
      <div>
        <InputLabel
          for="email"
          value="Email"
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
          value="Password"
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

      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">
          Save
        </PrimaryButton>

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition duration-500 delay-1000 ease-in-out"
          leave-to-class="opacity-0"
        >
          <p
            v-if="form.recentlySuccessful"
            class="text-sm text-gray-600"
          >
            A new confirmation link has been sent to the email address you provided.
          </p>
        </Transition>
      </div>
    </form>
  </section>
</template>
