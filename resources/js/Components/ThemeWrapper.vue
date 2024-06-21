<script setup>
import {onBeforeMount} from "vue";

const settings = localStorage.getItem('settings');

const theme = JSON.parse(settings)?.theme || 'system';

const setLightTheme = () => {
  document.documentElement.classList.remove('dark');
};

const setDarkTheme = () => {
  document.documentElement.classList.add('dark');
};

const setDefaultTheme = () => {
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');

  prefersDark.matches ? setDarkTheme() : setLightTheme();

  prefersDark.addEventListener('change', (event) => {
    event.matches ? setDarkTheme() : setLightTheme();
  });
};

onBeforeMount(() => {
  if (theme === 'dark') {
    setDarkTheme();
  } else if (theme === 'light') {
    setLightTheme();
  } else {
    setDefaultTheme();
  }
});
</script>

<template>
  <slot/>
</template>
