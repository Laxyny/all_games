/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        blue: {
          500: '#01a9f0',
        },
      },
    },
  },
  plugins: [],
}
