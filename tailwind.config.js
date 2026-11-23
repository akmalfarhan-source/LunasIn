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
            // =====================================================
            // WARNA TEMA LUNASIN
            // Warna didefinisikan di sini supaya konsisten di seluruh app.
            // =====================================================
            colors: {
                primary: {
                    DEFAULT: '#0EA5E9', // Sky 500 - warna utama tombol & link aktif
                    hover:   '#0284C7', // Sky 600 - hover tombol utama
                    light:   '#E0F2FE', // Sky 100 - latar aksen lembut
                    lighter: '#F0F9FF', // Sky 50  - latar halaman
                    border:  '#BAE6FD', // Sky 200 - border kartu
                },
            },
            fontFamily: {
                // Font Inter sebagai font utama (modern & bersih)
                sans: ['Inter', 'ui-sans-serif', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
