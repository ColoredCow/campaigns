import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
const withOpacity = (variableName) => {
    return ({ opacityValue }) => {
        if (opacityValue !== undefined) {
            return `rgba(var(${variableName}), ${opacityValue})`;
        }
        return `rgb(var(${variableName}))`;
    };
};

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.tsx",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "primary-900": withOpacity("--color-primary-900"),
            },
            borderColor: {
                "primary-900": withOpacity("--color-primary-900"),
            },
        },
    },

    plugins: [forms],
};
