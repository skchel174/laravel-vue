export default {
  install: (app, options) => {
    app.config.globalProperties.$trans = (key, replace = {}) => {
      let translation = app.config.globalProperties.$page.props.trans[key] || key;

      Object.keys(replace).forEach(function (key) {
        translation = translation.replace(`:${key}`, replace[key]);
      });

      return translation;
    };
  },
};
