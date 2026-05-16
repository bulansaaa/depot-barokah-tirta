import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                "on-primary": "#ffffff",
                "on-secondary-fixed-variant": "#005236",
                "on-tertiary-container": "#ffc278",
                "surface-container-lowest": "#ffffff",
                "primary": "#003c90",
                "on-primary-container": "#bcceff",
                "inverse-on-surface": "#eaf1ff",
                "surface-container": "#e5eeff",
                "surface-container-highest": "#d3e4fe",
                "on-error-container": "#93000a",
                "surface-dim": "#cbdbf5",
                "primary-fixed": "#d9e2ff",
                "on-background": "#0b1c30",
                "on-tertiary-fixed": "#2a1700",
                "surface-container-high": "#dce9ff",
                "surface": "#f8f9ff",
                "tertiary-fixed": "#ffddb8",
                "surface-tint": "#1d59c1",
                "on-secondary": "#ffffff",
                "secondary-fixed": "#6ffbbe",
                "on-error": "#ffffff",
                "secondary": "#006c49",
                "tertiary": "#5c3800",
                "on-surface-variant": "#434653",
                "secondary-container": "#6cf8bb",
                "on-secondary-fixed": "#002113",
                "on-primary-fixed": "#001945",
                "on-tertiary-fixed-variant": "#653e00",
                "surface-bright": "#f8f9ff",
                "tertiary-fixed-dim": "#ffb95f",
                "surface-container-low": "#eff4ff",
                "on-tertiary": "#ffffff",
                "tertiary-container": "#7c4d00",
                "outline-variant": "#c3c6d5",
                "background": "#f8f9ff",
                "inverse-primary": "#b0c6ff",
                "outline": "#737784",
                "on-surface": "#0b1c30",
                "secondary-fixed-dim": "#4edea3",
                "error": "#ba1a1a",
                "error-container": "#ffdad6",
                "primary-fixed-dim": "#b0c6ff",
                "primary-container": "#0f52ba",
                "inverse-surface": "#213145",
                "on-primary-fixed-variant": "#00419c",
                "on-secondary-container": "#00714d",
                "surface-variant": "#d3e4fe"
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                "headline-lg-mobile": ["Inter"],
                "label-sm": ["Inter"],
                "headline-md": ["Inter"],
                "body-lg": ["Inter"],
                "headline-lg": ["Inter"],
                "headline-sm": ["Inter"],
                "label-md": ["Inter"],
                "body-md": ["Inter"]
            },
            fontSize: {
                "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "700"}],
                "label-sm": ["11px", {"lineHeight": "14px", "fontWeight": "500"}],
                "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}]
            },
            spacing: {
                "margin-tablet": "24px",
                "margin-desktop": "32px",
                "gutter": "24px",
                "container-max-width": "1440px",
                "base": "8px"
            },
        },
    },

    plugins: [forms],
};
