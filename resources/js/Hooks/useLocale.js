import {ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";

function useLocale() {
  const page = usePage();
  const locale = ref(page.props.app.locale);
  const langs = ref(page.props.app.content_langs);

  const toggleLang = (locale) => {
    if (langs.value.includes(locale)) {
      const idx = langs.value.findIndex(lang => lang === locale);
      langs.value.splice(idx, 1);
    } else {
      langs.value.push(locale);
    }
  };

  const save = () => {
    router.post(route('locale'), {
      locale: locale.value,
      content_langs: langs.value,
    });
  };

  return {
    locale,
    langs,
    toggleLang,
    save,
  }
}

export default useLocale;
