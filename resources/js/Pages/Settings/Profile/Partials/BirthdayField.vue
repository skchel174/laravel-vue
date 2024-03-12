<script setup>
import moment from "moment";
import {computed, onMounted, ref, watch} from "vue";
import OptionsList from "@/Components/Form/Options.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import InputError from "@/Components/Form/InputError.vue";

const props = defineProps({
  modelValue: {
    type: String,
    required: true,
  },

  error: {
    type: String,
  },
});

const emit = defineEmits(['update:modelValue']);

const year = ref(null);

const years = computed(() => {
  const options = [];
  for (let i = 1954; i < 2015; i++) {
    options.push(i);
  }
  return options;
});

const month = ref(null);

const months = computed(() => {
  return moment.monthsShort().map((_, key) => ({
    key: key,
    name: moment().month(key).locale('en').format('MMMM'),
  }));
});

const day = ref(null);

const days = computed(() => {
  return (month.value && year.value)
    ? moment(month.value + '-' + year.value, 'MM-YYYY').daysInMonth()
    : [];
});

onMounted(() => {
  if (props.modelValue) {
    const date = moment(props.modelValue, 'DD-MM-YYYY');

    day.value = Number(date.format('DD'));
    month.value = Number(date.format('MM'));
    year.value = Number(date.format('YYYY'));
  }
});

watch([year, month, day], () => {
  if (year.value && month.value && day.value) {
    emit('update:modelValue', year.value + '-' + month.value + '-' + day.value);
  }
});
</script>

<template>
  <div class="flex flex-col space-y-2">
    <InputLabel :value="$trans('Birth date')"/>

    <OptionsList v-model="year">
      <option value="">
        {{ $trans('Year') }}
      </option>

      <option
        v-for="y in years"
        :value="y"
      >
        {{ y }}
      </option>
    </OptionsList>

    <OptionsList v-model="month">
      <option value="">
        {{ $trans('Month') }}
      </option>

      <option
        v-for="m in months"
        :value="m.key"
      >
        {{ $trans(m.name) }}
      </option>
    </OptionsList>

    <OptionsList v-model="day">
      <option value="">
        {{ $trans('Day') }}
      </option>

      <option
        v-for="d in days"
        :value="d"
        :selected="d === day"
      >
        {{ d }}
      </option>
    </OptionsList>

    <InputError :message="error"/>
  </div>
</template>
