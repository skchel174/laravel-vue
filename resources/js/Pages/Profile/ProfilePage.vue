<script setup>
import {onMounted} from "vue";
import {Head} from '@inertiajs/vue3';
import useNotification from "@/Hooks/useNotification.js";
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import ChangeEmailForm from "@/Pages/Profile/Partials/ChangeEmailForm.vue";
import SettingsLayout from "@/Layouts/SettingsLayout.vue";

const props = defineProps({
  status: {
    type: String,
  },

  error: {
    type: String,
  },
});

const {notice, showError, showSuccess} = useNotification();

onMounted(() => {
  if (props.error) {
    showError(props.error);
  }

  if (props.status) {
    showSuccess(props.status);
  }
});
</script>

<template>
  <SettingsLayout>
    <Head title="Profile"/>

    <div class="space-y-4">
      <header class="p-4 sm:px-8 sm:py-6 bg-white">
        <h1 class="font-semibold text-2xl text-gray-800 leading-tight">
          Profile settings
        </h1>
      </header>

      <div class="p-4 sm:p-8 bg-white">
        <UpdateProfileInformationForm :status="status"/>
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
  </SettingsLayout>
</template>
