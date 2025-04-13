<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import CardText from '@/Components/CardText.vue';
import CardBody from '@/Components/CardBody.vue';
import CardFooter from '@/Components/CardFooter.vue';
import Button from '@/Components/Button.vue';
import Card from '@/Components/Card.vue';
import Link from '@/Components/Link.vue';

const form = useForm({});

const submit = () => {
  form.post(route('register.resend'));
};
</script>

<template>
  <AuthLayout>
    <Head title="Resend Verification Email" />

    <Card class="mt-48 w-full max-w-lg sm:mt-0">
      <CardBody>
        <CardText>
          Thanks for signing up! Before getting started, could you verify your
          email address by clicking on the link we just emailed to you? If you
          didn\'t receive the email, we will gladly send you another.
        </CardText>
      </CardBody>

      <CardFooter class="justify-between">
        <Button @click="submit"> Resend verification email</Button>
        <Link href="#"> Logout </Link>
      </CardFooter>
    </Card>
  </AuthLayout>
</template>
