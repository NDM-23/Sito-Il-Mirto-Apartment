/** Config standalone per CSS pubblico (senza node_modules). La build Vite usa tailwind.config.js. */
module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './storage/framework/views/*.php',
    ],
    safelist: [
        // Layout full-screen
        'h-screen',
        // Typography
        'text-5xl', 'text-6xl', 'text-7xl',
        'md:text-5xl', 'md:text-6xl', 'lg:text-6xl', 'lg:text-7xl',
        'leading-none', 'leading-snug',
        // Gradients
        'bg-gradient-to-t', 'bg-gradient-to-r', 'bg-gradient-to-bl',
        'from-black/0', 'from-black/20', 'from-black/40', 'from-black/50',
        'from-black/60', 'from-black/70', 'from-black/80',
        'to-black/0', 'to-black/20', 'to-black/60', 'to-black/80',
        'to-transparent',
        'via-black/20', 'via-black/40',
        'bg-black/50', 'bg-black/60', 'bg-black/70',
        // Spacing
        'pt-16', 'pt-20', 'pt-24', 'pt-28', 'pt-32',
        'pb-16', 'pb-20', 'pb-24', 'pb-28', 'pb-32',
        'py-20', 'py-24', 'py-28', 'py-32',
        'px-8', 'px-12',
        // Gaps
        'gap-12', 'gap-14', 'gap-16', 'gap-20',
        // Space
        'space-y-8', 'space-y-12', 'space-y-16',
        // Grid
        'lg:grid-cols-4', 'md:grid-cols-2', 'lg:grid-cols-3',
        // Sizing
        'h-64', 'h-72', 'h-80', 'h-96',
        'h-[260px]', 'h-[300px]', 'h-[360px]', 'h-[420px]', 'h-[480px]', 'h-[520px]', 'h-[600px]',
        'min-h-[200px]', 'min-h-[280px]', 'min-h-[320px]', 'min-h-[400px]',
        'max-w-5xl', 'max-w-7xl', 'max-w-screen-xl',
        // Object
        'object-center', 'object-top', 'object-bottom',
        // Aspect
        'aspect-video', 'aspect-square', 'aspect-[4/3]', 'aspect-[3/4]', 'aspect-[16/9]', 'aspect-[1/1]',
        // Group hover
        'group',
        'group-hover:scale-105', 'group-hover:scale-110',
        'group-hover:opacity-80', 'group-hover:opacity-100',
        'group-hover:brightness-90', 'group-hover:brightness-110',
        'group-hover:text-mare',
        // Opacity
        'opacity-70', 'opacity-75', 'opacity-80', 'opacity-90',
        // Text
        'text-white/60', 'text-white/70', 'text-white/80', 'text-white/90',
        'text-black/60',
        // Borders
        'border-white/20', 'border-white/10',
        'border-mirto/20', 'border-mirto/30',
        // Backgrounds
        'bg-white/10', 'bg-white/20',
        'bg-mirto/10', 'bg-mirto/20', 'bg-mirto/90',
        'bg-mare/5', 'bg-mare/10', 'bg-mare/20', 'bg-mare/30',
        // Ring
        'ring-white/20', 'ring-white/30',
        // Transitions
        'duration-500', 'duration-700',
        'delay-75', 'delay-100', 'delay-150', 'delay-200', 'delay-300',
        // Translate
        '-translate-y-1', '-translate-y-2', 'translate-y-2',
        // Items
        'items-end',
        // Max height
        'max-h-96', 'max-h-[600px]',
        // Inset
        'inset-x-4',
        // Z-index
        'z-30',
        // Display
        'inline-flex',
        // Overflow
        'overflow-x-hidden',
        // Rounded
        'rounded-t-3xl',
        // Width
        'w-10', 'w-12', 'w-14', 'w-16',
        'h-10', 'h-12', 'h-14', 'h-16',
        // Hover colors
        'hover:text-white',
        'hover:border-mare',
        'hover:bg-white',
        // Decoration
        'underline-offset-4',
        // Negative margins
        '-mt-20', '-mt-24',
        // Nav / responsive
        'xl:hidden', 'xl:flex', 'xl:block', 'xl:gap-5',
        'lg:hidden', 'lg:flex', 'lg:block', 'lg:gap-4', 'lg:gap-5',
        'z-50', 'z-[55]', 'z-[60]',
        'max-h-[min(80vh,calc(100dvh-5rem))]',
        'group-open:rotate-180', 'open:shadow-md', 'open:ring-blue-100',
        'hidden', 'flex', 'block', 'inline-block',
        // Nav colors (used in Alpine :class bindings)
        'bg-white/95', 'bg-white/90', 'bg-white/80',
        'shadow-md', 'shadow-xl', 'shadow-2xl',
        'backdrop-blur-md', 'backdrop-blur-sm',
        // Blue palette classes
        'bg-blue-50', 'bg-blue-100', 'hover:bg-blue-50', 'hover:bg-blue-100',
        'text-blue-700', 'text-blue-600', 'text-blue-300',
        'border-blue-700', 'bg-blue-700', 'hover:bg-blue-700',
        'bg-indigo-50', 'bg-indigo-100', 'border-indigo-100', 'border-indigo-200', 'border-indigo-300',
        'text-indigo-700', 'bg-indigo-100', 'hover:bg-indigo-200',
        // Flex
        'flex-wrap', 'flex-col', 'flex-1', 'shrink-0',
        // Justify
        'justify-center', 'justify-between',
        // Min-width
        'min-w-0',
        // Scale
        'scale-95', 'scale-100',
        // Transition origin
        'origin-top-right',
        // Emerald
        'bg-emerald-50', 'border-emerald-200', 'border-emerald-300', 'text-emerald-700', 'text-emerald-800',
        'bg-emerald-100', 'hover:bg-emerald-100',
        // Rose
        'bg-rose-50', 'border-rose-200', 'text-rose-700', 'text-rose-800',
        'hover:bg-rose-100',
        // Amber
        'bg-amber-50', 'border-amber-200', 'border-amber-300', 'text-amber-700', 'text-amber-400',
        'bg-amber-400', 'hover:bg-amber-100',
        // File input
        'file:mr-3', 'file:cursor-pointer', 'file:rounded-full', 'file:border-0',
        'file:bg-blue-600', 'file:px-4', 'file:py-2', 'file:text-sm', 'file:font-semibold',
        'file:text-white', 'hover:file:bg-blue-700',
        // Animate
        'animate-spin', 'animate-bounce',
        // Grid cols
        'xl:grid-cols-4', 'sm:grid-cols-2', 'xl:grid-cols-3',
        // Rounded
        'rounded-lg', 'rounded-xl', 'rounded-2xl', 'rounded-3xl', 'rounded-full',
        // Border
        'border-t', 'border-b', 'border-l', 'border-r',
        // Focus
        'focus:border-blue-500', 'focus:ring-1', 'focus:ring-blue-500',
        // Negative margins
        '-mt-1', '-mt-5', '-bottom-5', '-right-5',
    ],
    theme: {
        extend: {
            colors: {
                mirto: { DEFAULT: '#1f5c4b', light: '#2d7a63' },
                mare: { DEFAULT: '#2fb5c3', deep: '#1a6f78' },
                sabbia: '#f6f1e8',
                cielo: '#e8f3f8',
                azzurro: { DEFAULT: '#6BAED6', light: '#ADD2E4', deep: '#3A7EB8', dark: '#1a4971' },
                costa: { DEFAULT: '#2b6a9e', dark: '#1a4971' },
            },
            fontFamily: {
                display: ['Cormorant Garamond', 'ui-serif', 'Georgia', 'serif'],
                sans: ['DM Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            backgroundImage: {
                wave: "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 120'%3E%3Cpath fill='%232fb5c3' fill-opacity='0.12' d='M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z'%3E%3C/path%3E%3C/svg%3E\")",
            },
        },
    },
    plugins: [],
};
