<script setup>
import {usePage} from "@inertiajs/vue3";
import {provide, reactive, watch} from "vue";
import AppAlert from "@/Components/AppAlert.vue";

const page = usePage();

const alert = reactive({
  type: 'info',
  message: '',
  duration: 0,
  visible: false,
});

const showAlert = (type, message, duration = 5000) => {
  alert.type = type;
  alert.message = message;
  alert.duration = duration;
  alert.visible = true;
};

provide('showAlert', showAlert);

watch(() => page.props.alert, () => {
  if (page.props.alert) {
    showAlert(page.props.alert.type, page.props.alert.message, 10000);
  }
}, {immediate: true});
</script>

<template>
  <slot/>

  <AppAlert
    :type="alert.type"
    v-model:visible="alert.visible"
    :duration="alert.duration"
  >
    {{ alert.message }}
  </AppAlert>
</template>
