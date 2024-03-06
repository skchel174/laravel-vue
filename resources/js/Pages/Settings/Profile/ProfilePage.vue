<script setup>
import {Head, useForm, usePage} from "@inertiajs/vue3";
import PageHeader from "@/Pages/Settings/Partials/PageHeader.vue";
import NavigationTabs from "@/Pages/Settings/Partials/NavigationTabs.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";
import AvatarInput from "@/Pages/Settings/Profile/Partials/AvatarInput.vue";
import LoginInput from "@/Pages/Settings/Profile/Partials/LoginInput.vue";
import NameInput from "@/Pages/Settings/Profile/Partials/NameInput.vue";
import AboutInput from "@/Pages/Settings/Profile/Partials/AboutInput.vue";
import SettingsLayout from "@/Components/Layouts/SettingsLayout.vue";

const user = usePage().props.auth.user;

const form = useForm({
  _method: 'patch',
  login: user.login ?? '',
  name: user.name ?? '',
  about: user.about ?? '',
  avatar: undefined,
});

const updateProfile = () => {
  form.post(route('settings.profile.update'), {
    preserveState: false,
  });
};
</script>

<template>
  <SettingsLayout>
    <Head :title="$ucfirst($trans('profile'))"/>

    <PageHeader/>

    <NavigationTabs current-tab="profile"/>

    <form
      class="mt-4 p-4 sm:p-6 bg-white space-y-6"
      @submit.prevent="updateProfile"
    >
      <AvatarInput
        v-model="form.avatar"
        :avatar="user.avatar"
        :error="form.errors.avatar"
      />

      <LoginInput
        v-model="form.login"
        :error="form.errors.login"
      />

      <NameInput
        v-model="form.name"
        :error="form.errors.name"
      />

      <AboutInput
        v-model="form.about"
        :error="form.errors.about"
      />

      <FilledButton
        color="success"
        :disabled="form.processing"
      >
        {{ $trans('Save changes') }}
      </FilledButton>
    </form>
  </SettingsLayout>
</template>

