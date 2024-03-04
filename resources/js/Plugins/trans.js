export default {
  install: (app, options) => {
    app.config.globalProperties.$trans = (key, replace = {}) => {

      const dictionary = app.config.globalProperties.$page.props.trans || {};

      let translation = key in dictionary
        ? app.config.globalProperties.$page.props.trans[key]
        : key;

      Object.keys(replace).forEach(function (key) {
        translation = translation.replace(`:${key}`, replace[key]);
      });

      return translation;
    };
  },
};
