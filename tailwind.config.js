import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                // Light theme palette
                warm: "#FAF7F2", // warm white
                beige: "#F3E9D7", // soft beige
                ash: "#E6E7EB", // light gray
                rosebeige: "#F4DED6", // beige-rose
                ink: "#1F2937", // dark text
            },
            boxShadow: {
                soft: "0 1px 3px rgba(31, 41, 55, 0.08), 0 1px 2px rgba(31, 41, 55, 0.04)",
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
