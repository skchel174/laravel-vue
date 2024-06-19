export default {
  install: (app, options) => {
    app.config.globalProperties.$trans = (key, replace = {}) => {
      const page = app.config.globalProperties.$page;
      const dictionary = page.props.localization.dictionary || {};

      let translation = key in dictionary ? dictionary[key] : key;

      Object.keys(replace).forEach(key => {
        translation = translation.replace(`:${key}`, replace[key]);
      });

      return translation;
    };
  }
};
