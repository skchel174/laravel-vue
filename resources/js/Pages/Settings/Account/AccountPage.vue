<script setup>
import {Head} from "@inertiajs/vue3";
import PageHeader from "@/Pages/Settings/Partials/PageHeader.vue";
import NavigationTabs from "@/Pages/Settings/Partials/NavigationTabs.vue";
import EmailForm from "@/Pages/Settings/Account/Partials/EmailForm.vue";
import PasswordForm from "@/Pages/Settings/Account/Partials/PasswordForm.vue";
import DeleteForm from "@/Pages/Settings/Account/Partials/DeleteForm.vue";
import SettingsLayout from "@/Components/Layouts/SettingsLayout.vue";
</script>

<template>
  <SettingsLayout>
    <Head :title="$trans('Account')"/>

    <PageHeader/>

    <NavigationTabs current-tab="account"/>

    <div class="mt-4 space-y-4">
      <EmailForm/>

      <PasswordForm/>

      <DeleteForm/>
    </div>
  </SettingsLayout>
</template>
