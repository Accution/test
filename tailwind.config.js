module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/css/**/*.css',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    light: '#4F8DFD',
                    DEFAULT: '#2563EB',
                    dark: '#1E40AF',
                },
                secondary: {
                    light: '#F3F4F6',
                    DEFAULT: '#6B7280',
                    dark: '#374151',
                },
                accent: {
                    DEFAULT: '#10B981',
                },
                background: {
                    DEFAULT: '#F9FAFB',
                    dark: '#111827',
                },
                white: '#FFFFFF',
                gray: {
                    light: '#F3F4F6',
                    DEFAULT: '#9CA3AF',
                    dark: '#374151',
                },
            },
            fontFamily: {
                sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [],
}; 