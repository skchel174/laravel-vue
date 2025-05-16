<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import FormLabel from '@/Components/FormLabel.vue';
import FormInput from '@/Components/FormInput.vue';
import FormError from '@/Components/FormError.vue';
import Button from '@/Components/Button.vue';
import Card from '@/Components/Card.vue';
import CardHeader from '@/Components/CardHeader.vue';
import CardTitle from '@/Components/CardTitle.vue';
import CardBody from '@/Components/CardBody.vue';
import CardSubtitle from '@/Components/CardSubtitle.vue';
import CardFooter from '@/Components/CardFooter.vue';
import Link from '@/Components/Link.vue';

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
    <Card class="w-full max-w-md">
      <CardHeader>
        <CardTitle>Registration</CardTitle>
        <CardSubtitle>
          Create your account. It's free and only takes a minute.
        </CardSubtitle>
      </CardHeader>

      <CardBody>
        <form class="space-y-4" @submit.prevent="submit">
          <div class="space-y-1">
            <FormLabel for="username" value="Username" />
            <FormInput
              id="username"
              type="text"
              v-model="form.username"
              required
            />
            <FormError :value="form.errors.username" />
          </div>

          <div class="space-y-1">
            <FormLabel for="email" value="Email" />
            <FormInput id="email" type="email" v-model="form.email" required />
            <FormError :value="form.errors.email" />
          </div>

          <div class="space-y-1">
            <FormLabel for="password" value="Password" />
            <FormInput
              id="password"
              type="password"
              v-model="form.password"
              required
            />
            <FormError :value="form.errors.password" />
          </div>

          <div class="space-y-1">
            <FormLabel for="password_confirmation" value="Confirm password" />
            <FormInput
              id="password_confirmation"
              type="password"
              v-model="form.password_confirmation"
              required
            />
            <FormError :value="form.errors.password_confirmation" />
          </div>

          <div class="pt-4">
            <Button class="w-full" :disabled="form.processing">
              Register
            </Button>
          </div>
        </form>
      </CardBody>

      <CardFooter class="justify-center space-x-2">
        <CardSubtitle>Already registered?</CardSubtitle>
        <Link href="#">Log in</Link>
      </CardFooter>
    </Card>
  </AuthLayout>
</template>
