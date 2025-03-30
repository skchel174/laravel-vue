<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import FormLabel from '@/Components/FormLabel.vue';
import FormInput from '@/Components/FormInput.vue';
import FormError from '@/Components/FormError.vue';
import Button from '@/Components/Button.vue';

const form = useForm({
  email: '',
  username: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <Head title="Registration" />

  <AuthLayout>
    <div
      class="flex h-full w-full max-w-lg flex-col justify-between space-y-4 sm:justify-center"
    >
      <form
        class="space-y-4 rounded-md border-gray-300 p-4 sm:border sm:p-6 sm:py-8"
        @submit.prevent="submit"
      >
        <header class="mb-8 sm:mb-4">
          <h2 class="text-xl font-semibold capitalize">Registration</h2>
        </header>

        <div class="space-y-2">
          <FormLabel for="username" value="Username" />
          <FormInput
            id="username"
            type="text"
            v-model="form.username"
            color="error"
            required
          />
          <FormError :value="form.errors.username" />
        </div>

        <div class="space-y-2">
          <FormLabel for="email" value="Email" />
          <FormInput
            id="email"
            type="email"
            v-model="form.email"
            required
          />
          <FormError :value="form.errors.email" />
        </div>

        <div class="space-y-2">
          <FormLabel for="password" value="Password" />
          <FormInput
            id="password"
            type="password"
            v-model="form.password"
            required
          />
          <FormError :value="form.errors.password" />
        </div>

        <div class="space-y-2">
          <FormLabel for="password_confirmation" value="Confirm password" />
          <FormInput
            id="password_confirmation"
            type="password"
            v-model="form.password_confirmation"
            required
          />
          <FormError :value="form.errors.password_confirmation" />
        </div>

        <div class="pt-6 flex items-center justify-end flex-col space-y-6">
<!--          <Button-->
<!--            color="primary"-->
<!--            class="w-full !py-4 !text-sm"-->
<!--            :class="{ 'opacity-25': form.processing }"-->
<!--            :disabled="form.processing"-->
<!--          >-->
<!--            Register-->
<!--          </Button>-->

          <Button
            color="primary"
            size="sm"
            class="w-full"
          >
            Register
          </Button>

          <Button
            color="secondary"
            size="md"
            class="w-full"
          >
            Register
          </Button>

          <Button
            color="danger"
            size="lg"
            class="w-full"
          >
            Register
          </Button>

          <Button
            variant="outlined"
            color="primary"
            size="sm"
            class="w-full"
          >
            Register
          </Button>

          <Button
            variant="outlined"
            color="secondary"
            size="md"
            class="w-full"
          >
            Register
          </Button>

          <Button
            variant="outlined"
            color="danger"
            size="lg"
            class="w-full"
          >
            Register
          </Button>
        </div>
      </form>

      <div class="flex w-full max-w-lg justify-center bg-white p-6">
        <p class="text-xs font-medium text-gray-600 sm:text-sm">
          Already registered?

          <Link
            :href="route('main')"
            class="text-sky-675 hover:text-sky-775 ml-1 font-semibold capitalize transition duration-200"
          >
            Log in
          </Link>
        </p>
      </div>
    </div>
  </AuthLayout>
</template>
