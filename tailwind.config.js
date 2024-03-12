import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },

      width: {
        '75': '18.75rem',
      },

      padding: {
        '1.25': '0.313rem',
      },

      transitionDuration: {
        '400': '400ms',
      },

      colors: {
        sky: {
          675: 'rgba(97, 141, 181)',
          775: 'rgba(93, 130, 161)',
        },
        lime: {
          680: 'rgba(121, 148, 82)',
          775: 'rgba(119, 142, 86)',
        },
        red: {
          675: 'rgba(191, 98, 93)',
          775: 'rgba(169, 94, 90)',
        },
        gray: {
          275: 'rgba(229, 231, 235)',
          350: 'rgba(192, 192, 192)',
          475: 'rgba(145, 149, 159)',
        },
      },
    },
  },

  plugins: [forms],
};
