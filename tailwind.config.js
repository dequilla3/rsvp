import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                serif: ["Cormorant Garamond", "serif"],
                script: ["Great Vibes", "cursive"],
            },

            colors: {
                wedding: {
                    cream: "#f8f3ec",
                    beige: "#e9ded0",
                    sand: "#d8c7b5",
                    brown: "#8a6f5a",
                    dark: "#3f342c",
                    muted: "#9a8878",
                },
            },
        },
    },

    plugins: [forms],
};
