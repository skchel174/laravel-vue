<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import CardHeader from "@/Components/CardHeader.vue";
import CardTitle from "@/Components/CardTitle.vue";
import CardBody from "@/Components/CardBody.vue";
import CardSubtitle from "@/Components/CardSubtitle.vue";
import FormError from "@/Components/FormError.vue";
import FormLabel from "@/Components/FormLabel.vue";
import FormInput from "@/Components/FormInput.vue";
import CardFooter from "@/Components/CardFooter.vue";
import Button from "@/Components/Button.vue";
import Link from '@/Components/Link.vue';

const form = useForm({
  email: '',
  password: '',
});

const submit = () => {
  console.log(form.data())
};
</script>

<template>
  <AuthLayout>
    <Head title="Login"/>

    <Card class="w-full max-w-sm">
      <CardHeader class="space-y-4 sm:space-y-1">
        <CardTitle class="text-3xl sm:text-base">
          Log in
        </CardTitle>
        <CardSubtitle>
          Enter your email below to login to your account.
        </CardSubtitle>
      </CardHeader>

      <CardBody>
        <form class="space-y-4" @submit.prevent="submit">
          <div class="space-y-1">
            <FormLabel for="email" value="Email"/>
            <FormInput id="email" type="email" v-model="form.email" required/>
            <FormError :value="form.errors.email"/>
          </div>

          <div class="space-y-1">
            <FormLabel for="password" value="Password"/>
            <FormInput
              id="password"
              type="password"
              v-model="form.password"
              required
            />
            <FormError :value="form.errors.password"/>
          </div>

          <div class="pt-4">
            <Button class="w-full" :disabled="form.processing">
              Login
            </Button>

            <Link class="mt-3 sm:mt-2" href="#">Forgot your password?</Link>
          </div>
        </form>
      </CardBody>

      <CardFooter class="justify-center space-x-1">
        <CardSubtitle>Already registered?</CardSubtitle>
        <Link :href="route('register')">Register</Link>
      </CardFooter>
    </Card>
  </AuthLayout>
</template>
