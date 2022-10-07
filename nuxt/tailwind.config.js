/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./components/**/*.{js,vue,ts}",
    "./layouts/**/*.vue",
    "./pages/**/*.vue",
    "./plugins/**/*.{js,ts}",
    "./nuxt.config.{js,ts}",
  ],
  theme: {
    daisyui: {
      themes: [
        {
          mytheme: {
          
 "primary": "#FF7AC6",
          
 "secondary": "#BF95F9",
          
 "accent": "#FFB86B",
          
 "neutral": "#414558",
          
 "base-100": "#272935",
          
 "info": "#8BE8FD",
          
 "success": "#52FA7C",
          
 "warning": "#F1FA89",
          
 "error": "#FF5757",
          },
        },
      ],
    }
  },
}