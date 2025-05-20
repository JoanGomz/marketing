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
            fontFamily: {
                sans: ['Titillium Web', ...defaultTheme.fontFamily.sans],
                secondary: ['Orbitron', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    gray: '#555555',
                    blue: '#007BFF',
                    purple: '#581c94',
                    pink: '#FF00FF',
                    darkPurple: '#180c44',
                    aqua: '#00FFFF',
                    redStar: '#B31F28',
                    blueStar: '#0078B6'
                }
            },
            backgroundImage: {
                'gradient-button': 'linear-gradient(to right, #581c94 0%, #581c94 10%, #180c44 100%)',
                'gradient-card': 'linear-gradient(to right, #581c94 0%, #581c94 10%, #180c44 100%)',
            },
            fontSize: {
                sm: '1rem',
            },
            scale: {
                '105': '1.03',
            },
            // Añadir alturas mínimas para contenedores
            minHeight: {
                'table-cell': '3rem',
                'nav-link': '3.5rem',
                'scroll-container': '100px',
            },
        },
    },
    
    plugins: [
        forms,
        // Plugin para fuentes con propiedades optimizadas
        function ({ addBase, theme }) {
            addBase({
                'body': { 
                    fontFamily: theme('fontFamily.sans'),
                    fontDisplay: 'swap',
                },
                'h1, h2, h3, h4, h5, h6, span': { 
                    fontFamily: theme('fontFamily.secondary'),
                    fontDisplay: 'swap',
                    lineHeight: '1.2',
                    minHeight: 'max-content',
                    fontSizeAdjust: '0.5',
                },
                // Estilos para el contenedor de scroll problemático
                'div[class*="::-webkit-scrollbar"]': {
                    minHeight: theme('minHeight.scroll-container'),
                    contain: 'layout',
                },
                // Estilos para celdas de tabla
                'th.text-center': {
                    height: theme('minHeight.table-cell'),
                    minHeight: theme('minHeight.table-cell'),
                },
                // Estilos para enlaces
                'a.flex.gap-2.py-4': {
                    height: theme('minHeight.nav-link'),
                    minHeight: theme('minHeight.nav-link'),
                }
            });
        },
        // Otros plugins...
        function ({ addUtilities }) {
            const newUtilities = {
                '.nocard-hover-effect': {
                    '@apply flex flex-col gap-2 relative bg-gradient-to-tr from-indigo-600 to-brand-purple text-white p-6 rounded-2xl shadow-lg transform hover:scale-105 transition duration-300': {}
                },
                // Utilidad para prevenir CLS
                '.prevent-cls': {
                    'min-height': 'max-content',
                    'font-display': 'swap',
                    'contain': 'layout',
                },
                // Utilidad específica para el elemento con mayor desplazamiento
                '.scroll-container-stable': {
                    'min-height': '100px',
                    'height': 'auto',
                    'contain': 'layout',
                }
            }
            addUtilities(newUtilities)
        }
    ],
};