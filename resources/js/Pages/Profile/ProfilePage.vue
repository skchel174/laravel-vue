<script setup>
import {Head} from '@inertiajs/vue3';
import ChangeEmailForm from "@/Pages/Profile/Partials/ChangeEmailForm.vue";
import BaseLayout from "@/Components/Layouts/BaseLayout.vue";
import UpdateProfileForm from "@/Pages/Profile/Partials/UpdateProfileForm.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.vue";
</script>

<template>
  <BaseLayout>
    <Head :title="$trans('Profile settings')"/>

    <div class="space-y-4">
      <header class="p-4 sm:px-8 sm:py-6 bg-white">
        <h1 class="font-semibold text-2xl text-gray-800 leading-tight">
          {{ $trans('Profile settings') }}
        </h1>
      </header>

      <div class="p-4 sm:p-8 bg-white">
        <UpdateProfileForm/>
      </div>

      <div class="p-4 sm:p-8 bg-white">
        <ChangeEmailForm/>
      </div>

      <div class="p-4 sm:p-8 bg-white">
        <UpdatePasswordForm/>
      </div>

      <div class="p-4 sm:p-8 bg-white">
        <DeleteUserForm/>
      </div>
    </div>
  </BaseLayout>
</template>
