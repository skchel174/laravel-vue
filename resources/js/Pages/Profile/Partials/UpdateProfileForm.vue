<script setup>
import {useForm, usePage} from '@inertiajs/vue3';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import InputLength from "@/Components/Form/InputLength.vue";
import AvatarInput from "@/Pages/Profile/Partials/AvatarInput.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

defineProps({
  status: {
    type: String,
  },
});

const user = usePage().props.auth.user;

const form = useForm({
  _method: 'patch',
  login: user.login ?? '',
  name: user.name ?? '',
  about: user.about ?? '',
  avatar: undefined,
});

const submit = () => {
  form.post(route('profile.update'), {
    preserveState: false,
  });
};
</script>

<template>
  <section>
    <header class="flex items-center space-x-4">
      <div class="h-8 w-8 bg-green-600 flex items-center justify-center rounded-sm">
        <span class="material-icons !text-base text-white">
          manage_accounts
        </span>
      </div>

      <h2 class="text-lg font-medium text-gray-900 leading-none">
        {{ $trans('Update Profile') }}
      </h2>
    </header>

    <form
      class="mt-8 flex-1 flex flex-col lg:flex-row"
      @submit.prevent="submit"
    >
      <AvatarInput
        class="max-w-2xl order-1 lg:order-2 lg:ml-16 mb-8"
        v-model="form.avatar"
        :avatar="user.avatar"
        :error="form.errors.avatar"
      />

      <div class="max-w-2xl w-full order-2 lg:order-1 space-y-6">
        <div>
          <div class="flex justify-between items-center">
            <InputLabel
              for="login"
              :value="$trans('Login')"
            />

            <InputLength
              :input="form.login"
              :max-length="25"
            />
          </div>

          <TextInput
            id="login"
            type="text"
            class="mt-1 block w-full"
            v-model="form.login"
            required
          />

          <InputError
            class="mt-2"
            :message="form.errors.login"
          />
        </div>

        <div>
          <div class="flex justify-between items-center">
            <InputLabel
              for="name"
              :value="$trans('Actual name')"
            />

            <InputLength
              :input="form.name"
              :max-length="60"
            />
          </div>

          <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
          />

          <InputError
            class="mt-2"
            :message="form.errors.name"
          />
        </div>

        <div>
          <div class="flex justify-between items-center">
            <InputLabel
              for="about"
              :value="$trans('Describe yourself')"
            />

            <InputLength
              :input="form.about"
              :max-length="50"
            />
          </div>

          <TextInput
            id="about"
            type="text"
            class="mt-1 block w-full"
            v-model="form.about"
          />

          <InputError
            class="mt-2"
            :message="form.errors.about"
          />
        </div>

        <div class="mt-6 flex items-center">
          <FilledButton
            color="primary"
            :disabled="form.processing"
          >
            {{ $trans('Save') }}
          </FilledButton>

          <Transition
            enter-from-class="opacity-0"
            leave-to-class="opacity-0"
            class="transition ease-in-out"
          >
            <p
              v-if="form.recentlySuccessful"
              class="ml-2 text-sm text-gray-600"
            >
              {{ $trans('Profile saved') }}
            </p>
          </Transition>
        </div>
      </div>
    </form>
  </section>
</template>
