<script setup>
import {ref} from "vue";
import Options from "@/Components/Form/Options.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";

const props = defineProps({
  contactTypes: {
    type: Array,
    required: true,
  },

  modelValue: {
    type: Array,
    required: true,
  },

  error: {
    type: String,
  },
});

const emit = defineEmits(['update:modelValue']);

const contacts = ref(props.modelValue);

const addRow = () => {
  contacts.value.push({
    name: props.contactTypes[0].name,
    contact_type_id: props.contactTypes[0].id,
    value: '',
  });
};

const removeRow = (key) => {
  contacts.value.splice(key, 1);
};

const onSelect = (key, name) => {
  const idx = props.contactTypes.findIndex(i => i.name === name);
  contacts.value[key].contact_type_id = props.contactTypes[idx].id;
  contacts.value[key].name = name;
};

const onInput = (key, value) => {
  contacts.value[key].value = value;
  emit('update:modelValue', contacts.value);
};
</script>

<template>
  <div class="flex flex-col space-y-2">
    <InputLabel :value="$trans('Contacts')"/>

    <hr class="bg-gray-300"/>

    <p class="text-xs text-gray-400">
      {{ $trans('Enter your login or ID and we will create the link ourselves.') }}
    </p>

    <div
      class="flex space-x-2"
      v-for="(contact, key) in contacts"
    >
      <Options
        class="w-full min-w-[6rem] max-w-[9rem]"
        :model-value="contact.name"
        @update:model-value="value => onSelect(key, value)"
      >
        <option v-for="type in contactTypes">
          {{ type.name }}
        </option>
      </Options>

      <TextInput
        class="grow shrink"
        :model-value="contact.value"
        @update:model-value="value => onInput(key, value)"
      />

      <div
        class="shrink-0 w-10 h-10 flex justify-center items-center border border-gray-300 rounded-sm cursor-pointer text-gray-400 hover:text-red-600/75 transition duration-200"
        @click="removeRow(key)"
      >
        <MaterialIcon class="!text-2xl">
          delete_outline
        </MaterialIcon>
      </div>
    </div>

    <InputError :message="error"/>

    <OutlineButton
      class="!mt-4 !px-2 max-w-[9rem]"
      color="primary"
      @click.prevent="addRow"
    >
      {{ $trans('Add link') }}
    </OutlineButton>
  </div>
</template>
