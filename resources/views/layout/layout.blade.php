<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body>
    {{-- <div class="w-full h-auto min-h-screen flex flex-col bg-zinc-900"> --}}
        <div class="w-full bg-zinc-900 h-[96px] drop-shadow-[0_10px_8px_rgb(255,255,255,0.25)] flex flex-row items-center">
            <div class="w-1/3 pl-5">
                <a href="/movies" class="uppercase text-base mx-5 text-white hover:text-sky-500 duration-200 font-inter">Movies</a>
                <a href="/tv-shows" class="uppercase text-base mx-5 text-white hover:text-sky-500 duration-200 font-inter">TV Shows</a>
            </div>

            <div class="w-1/3 flex items-center justify-center">
                <a href="/" class="font-bold text-5xl font-serif text-white hover:text-sky-500 duration-200">MovieTube</a>
            </div>

            <div class="w-1/3 flex flex-row justify-end pr-10">
                <a href='/search' class='group'>
                    <svg width='32' height='32' viewBox='0 0 32 32' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M28.525 27.475L22.9625 21.9C24.8885 19.6983 25.8834 16.8343 25.7372 13.9127C25.591 10.9911 24.315 8.24072 22.1787 6.24237C20.0425 4.24402 17.2132 3.15414 14.2883 3.20291C11.3635 3.25167 8.57212 4.43526 6.50367 6.50371C4.43521 8.57217 3.25163 11.3636 3.20286 14.2884C3.1541 17.2132 4.24397 20.0425 6.24233 22.1788C8.24068 24.315 10.9911 25.591 13.9126 25.7372C16.8342 25.8835 19.6983 24.8885 21.9 22.9625L27.475 28.525C27.6142 28.6642 27.803 28.7425 28 28.7425C28.1969 28.7425 28.3857 28.6642 28.525 28.525C28.6642 28.3858 28.7424 28.1969 28.7424 28C28.7424 27.8031 28.6642 27.6142 28.525 27.475ZM4.74996 14.5C4.74996 12.5716 5.32178 10.6866 6.39313 9.08319C7.46447 7.47981 8.98721 6.23013 10.7688 5.49218C12.5504 4.75422 14.5108 4.56114 16.4021 4.93734C18.2934 5.31355 20.0307 6.24215 21.3942 7.60571C22.7578 8.96927 23.6864 10.7066 24.0626 12.5979C24.4388 14.4892 24.2457 16.4496 23.5078 18.2312C22.7698 20.0127 21.5201 21.5355 19.9168 22.6068C18.3134 23.6782 16.4283 24.25 14.5 24.25C11.9151 24.2467 9.43708 23.2184 7.60932 21.3906C5.78155 19.5629 4.75326 17.0848 4.74996 14.5Z'
                        class='fill-white group-hover:fill-sky-500 duration-200'/>
                    </svg>
                </a>
            </div>
        </div>
    {{-- </div> --}}
    <div>@yield('content')</div>

    <div class="w-full bg-stone-800 h-[320px] text-white flex flex-row pt-12">
        <div class="w-6/12 pl-28 flex flex-col">
            <span class="font-serif text-4xl font-bold">MovieTube</span>
            <span class="font-serif text-lg mt-4">We provide reviews of movies and TV shows</span>
            <span class="font-serif text-lg mt-14">&copy 2024 MovieTube</span>
        </div>

        <div class="w-3/12 flex flex-col">
            <span class="font-serif font-bold text-lg">Website</span>
            <a href="/" class="font-serif text-lg mt-4 hover:text-sky-500 duration-200">Home</a>
            <a href="/movies" class="font-serif text-lg mt-4 hover:text-sky-500 duration-200">Movies</a>
            <a href="/tv-shows" class="font-serif text-lg mt-4 hover:text-sky-500 duration-200">TV Shows</a>
        </div>

        <div class="w-3/12 flex flex-col">
            <span class="font-serif font-bold text-lg">Social Media:</span>
            <a href="#" class="font-serif text-lg mt-4 hover:text-sky-500 duration-200">Instagram</a>
            <a href="#" class="font-serif text-lg mt-4 hover:text-sky-500 duration-200">WhatsApp</a>
            <a href="#" class="font-serif text-lg mt-4 hover:text-sky-500 duration-200">Facebook</a>
        </div>
    </div>
</body>
</html>
