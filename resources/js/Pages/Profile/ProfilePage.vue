<script setup>
import {onMounted} from "vue";
import {Head} from '@inertiajs/vue3';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import ChangeEmailForm from "@/Pages/Profile/Partials/ChangeEmailForm.vue";
import Notification from "@/Components/Notification.vue";
import useNotification from "@/Hooks/useNotification.js";

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
  <Head title="Profile"/>

  <div class="w-full max-w-3xl lg:max-w-5xl h-full mx-auto flex flex-col">
    <div class="sm:p-4 space-y-4">
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

    <Notification
      :type="notice.type"
      v-model:visible="notice.visible"
    >
      {{ notice.message }}
    </Notification>
  </div>
</template>
