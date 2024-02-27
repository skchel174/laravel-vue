import {ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";

function usePageSettings() {
  const page = usePage();

  const view = ref(page.props.view);
  const locale = ref(page.props.locale);
  const langs = ref(page.props.langs);

  const toggleLang = (locale) => {
    if (langs.value.includes(locale)) {
      const idx = langs.value.findIndex(lang => lang === locale);
      langs.value.splice(idx, 1);
    } else {
      langs.value.push(locale);
    }
  };

  const save = () => {
    router.post(route('page.settings'), {
      view: view.value,
      locale: locale.value,
      langs: langs.value,
    });
  };

  return {
    view,
    locale,
    langs,
    toggleLang,
    save,
  }
}

export default usePageSettings;
