import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import lineClamp from '@tailwindcss/line-clamp'

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
      colors: {
        primary: '#1f2937',
        secondary: '#4b5563',
        accent: '#f59e0b',
      },
      fontFamily: {
        sans: ['Poppins', ...defaultTheme.fontFamily.sans],
      },
    },
  },

  plugins: [
    forms,
    lineClamp,
  ],
}
