<script setup>
import {computed} from "vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import PageHeader from "@/Pages/Settings/Partials/PageHeader.vue";
import NavigationTabs from "@/Pages/Settings/Partials/NavigationTabs.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";
import AvatarInput from "@/Pages/Settings/Profile/Partials/AvatarInput.vue";
import LoginInput from "@/Pages/Settings/Profile/Partials/LoginInput.vue";
import NameInput from "@/Pages/Settings/Profile/Partials/NameInput.vue";
import AboutInput from "@/Pages/Settings/Profile/Partials/AboutInput.vue";
import SettingsLayout from "@/Components/Layouts/SettingsLayout.vue";
import BirthdayField from "@/Pages/Settings/Profile/Partials/BirthdayField.vue";
import GenderField from "@/Pages/Settings/Profile/Partials/GenderField.vue";
import ContactLinks from "@/Pages/Settings/Profile/Partials/ContactLinks.vue";

const props = defineProps({
  contacts: {
    type: Array,
    required: true,
  },

  contactTypes: {
    type: Array,
    required: true,
  },
});

const user = usePage().props.auth.user;

const form = useForm({
  _method: 'patch',
  username: user.username ?? '',
  fullname: user.fullname ?? '',
  about: user.about ?? '',
  gender: user.gender ?? '',
  birthday: user.birthday ?? '',
  contacts: props.contacts ?? [],
  avatar: undefined,
});

const contactsError = computed(() => {
  for (let prop in form.errors) {
    if (prop.startsWith('contacts')) {
      return form.errors[props];
    }
  }
});

const updateProfile = () => {
  form.post(route('settings.profile.update'), {
    preserveState: 'errors',
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
        :username="form.username"
        :error="form.errors.avatar"
      />

      <LoginInput
        v-model="form.username"
        :error="form.errors.username"
      />

      <NameInput
        v-model="form.fullname"
        :error="form.errors.fullname"
      />

      <AboutInput
        v-model="form.about"
        :error="form.errors.about"
      />

      <GenderField
        v-model="form.gender"
        :error="form.errors.gender"
      />

      <BirthdayField
        v-model="form.birthday"
        :error="form.errors.birthday"
      />

      <ContactLinks
        v-model="form.contacts"
        :contact-types="contactTypes"
        :error="contactsError"
      />

      <FilledButton
        class="!mt-12"
        color="success"
        :disabled="form.processing"
      >
        {{ $trans('Save changes') }}
      </FilledButton>
    </form>
  </SettingsLayout>
</template>

