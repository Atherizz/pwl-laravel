<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Savero Athallah</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;600;800&display=swap" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>
        
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            navy: {
                                900: '#0a192f', // Deep Modern Navy
                                800: '#112240', // Lighter Navy for accents
                            }
                        },
                        animation: {
                            'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                            'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        },
                        keyframes: {
                            fadeInUp: {
                                '0%': { opacity: '0', transform: 'translateY(20px)' },
                                '100%': { opacity: '1', transform: 'translateY(0)' },
                            }
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="bg-navy-900 h-screen w-full flex flex-col items-center justify-center overflow-hidden selection:bg-blue-500 selection:text-white">

        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-[100px] animate-pulse-slow"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-[100px] animate-pulse-slow delay-1000"></div>

        <main class="relative z-10 text-center px-4">
            <h1 class="text-white text-5xl md:text-7xl lg:text-8xl font-extrabold tracking-tighter opacity-0 animate-fade-in-up drop-shadow-2xl">
                Savero Athallah
            </h1>
            
            <div class="mt-6 h-1 w-0 bg-white rounded-full mx-auto animate-[width_1s_ease-out_0.5s_forwards] w-24 opacity-80"></div>
        </main>

        <footer class="absolute bottom-6 text-slate-400 text-xs tracking-widest uppercase opacity-50">
            &copy; {{ date('Y') }}
        </footer>

        <style>
            @keyframes width {
                from { width: 0; }
                to { width: 6rem; }
            }
        </style>
    </body>
</html>