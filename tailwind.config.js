/** @type {import('tailwindcss').Config} */
export default {
    content:  ["./resources/**/*.{html,js,blade.php}"],
    theme:    {
        extend: {},
    },
    plugins:  [],
    safelist: [
        {
            pattern: /grid-cols-(1|2|3|4|5|6)/,
            variants: ['sm', 'md', 'lg', 'xl', '2xl'],
        },
    ]
}

