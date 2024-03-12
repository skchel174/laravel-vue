<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import SettingsLayout from "@/Components/Layouts/SettingsLayout.vue";
import PageHeader from "@/Pages/Settings/Partials/PageHeader.vue";
import NavigationTabs from "@/Pages/Settings/Partials/NavigationTabs.vue";
import RadioButton from "@/Components/Form/RadioButton.vue";
import PrivacyRule from "@/Pages/Settings/Privacy/Partials/PrivacyRule.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

const form = useForm({
  contacts: 'everyone',
  messages: 'followers',
  activity: 'followers',
});

</script>

<template>
  <SettingsLayout>
    <Head :title="$trans('Account')"/>

    <PageHeader/>

    <NavigationTabs current-tab="privacy"/>

    <form class="mt-4 px-4 sm:px-6 pt-8 pb-4 bg-white space-y-6">
      <PrivacyRule heading="Who can see your contact information">
        <RadioButton
          id="contacts_everyone"
          :label="$trans('Everyone')"
          :model-value="form.contacts === 'everyone'"
          @update:model-value="form.contacts = 'everyone'"
        />

        <RadioButton
          id="contacts_followers"
          :label="$trans('Followers')"
          :model-value="form.contacts === 'followers'"
          @update:model-value="form.contacts = 'followers'"
        />
      </PrivacyRule>

      <PrivacyRule heading="Who can send you messages">
        <RadioButton
          id="messages_nobody"
          :label="$trans('Nobody')"
          :model-value="form.messages === 'nobody'"
          @update:model-value="form.messages = 'nobody'"
        />

        <RadioButton
          id="messages_followers"
          :label="$trans('Followers')"
          :model-value="form.messages === 'followers'"
          @update:model-value="form.messages = 'followers'"
        />
      </PrivacyRule>

      <PrivacyRule heading="Who can track your activity">
        <RadioButton
          id="activity_nobody"
          :label="$trans('Nobody')"
          :model-value="form.activity === 'nobody'"
          @update:model-value="form.activity = 'nobody'"
        />

        <RadioButton
          id="activity_followers"
          :label="$trans('Followers')"
          :model-value="form.activity === 'followers'"
          @update:model-value="form.activity = 'followers'"
        />
      </PrivacyRule>

      <FilledButton color="success">
        {{ $trans('Save changes') }}
      </FilledButton>
    </form>
  </SettingsLayout>
</template>
