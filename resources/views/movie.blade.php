<div class="w-full h-auto min-h-screen flex flex-col bg-zinc-900">

    @extends('layout.layout')

    @section('title', 'MovieTube')

    @section('content')

    {{-- Select Section --}}
    <div class="ml-28 mt-8 flex flex-row items-center">
        <span class="font-serif font-bold text-xl text-white">Sort</span>

        <div class="relative ml-4">
            <select
                class="block appearance-none bg-white drop-shadow-[0_0px_5px_rgba(255,255,255,0.25)] text-black font-serif py-3 pl-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white"
                onchange="changeSort(this)">
                <option value="popularity.desc">Popularity (Descending)</option>
                <option value="popularity.asc">Popularity (Ascending)</option>
                <option value="vote_average.desc">Top Rated (Descending)</option>
                <option value="vote_average.asc">Top Rated (Ascending)</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Tampilan Movies --}}
    <div class="w-auto pl-28 pr-10 pt-6 pb-10 grid grid-cols-3 lg:grid-cols-5 gap-5" id="dataWrapper">
        @foreach ($movies as $moviesItems)

        @php
        $original_date = $moviesItems->release_date;
        $timestamp = strtotime($original_date);

        $moviesYear = date("Y", $timestamp);
        $moviesID = $moviesItems->id;
        $moviesTitle = $moviesItems->title;
        $moviesRating = $moviesItems->vote_average * 10;
        $moviesImage = "{$imageBaseURL}/w500{$moviesItems->poster_path}";

        @endphp

        <a href="movie/{{ $moviesID }}" class="group">
            <div class="min-w-[232px] min-h-[428px] bg-zinc-900 drop-shadow-[0_0px_8px_rgba(255,255,255,0.2)] group-hover:drop-shadow-[0_0px_8px_rgba(255,255,255,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                <div class="overflow-hidden rounded-[32px]">
                    <img class="w-[full] h-[300px] rounded-[32px] group-hover:scale-105 duration-200" src="{{ $moviesImage }}">
                </div>

                <span class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none text-white">{{ $moviesTitle }}</span>
                <span class="font-inter text-sm mt-1 text-white">{{ $moviesYear }}</span>

                <div class="flex flex-row mt-1 items-center">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 21H8V8L15 1L16.25 2.25C16.3667 2.36667 16.4627 2.525 16.538 2.725C16.6127 2.925 16.65 3.11667 16.65 3.3V3.65L15.55 8H21C21.5333 8 22 8.2 22.4 8.6C22.8 9 23 9.46667 23 10V12C23 12.1167 22.9873 12.2417 22.962 12.375C22.9373 12.5083 22.9 12.6333 22.85 12.75L19.85 19.8C19.7 20.1333 19.45 20.4167 19.1 20.65C18.75 20.8833 18.3833 21 18 21ZM6 8V21H2V8H6Z" fill="#38B6FF"></path>
                    </svg>

                    <span class="font-inter text-sm ml-1 text-white font-bold">{{ $moviesRating }}%</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Notifikasi JIka terjadi masalah --}}
    <div class="min-w-[250px] p-4 bg-red-700 text-white text-center rounded-lg fixed z-index-10 top-1 right-0 mr-10 mt-5 drop-shadow-lg" id="notification">
        <span id="NotificationMessage"></span>
    </div>

    {{-- Gambar Loading --}}
    <div cla
    ss="w-full pl-28 pr-10 flex justify-center mb-5" id="autoLoad">
        <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
            <path fill="#FFF
            " d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
              <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
            </path>
          </svg>
    </div>

    {{-- Tombol Load More --}}
    <div class="w-full pl-28 pr-10 pb-10" id="loadMore">
        <button class="w-full bg-sky-500 text-white p-4 font-serif font-bold rounded-full uppercase drop-shadow-[0_0_4px_rgba(255,255,255,0.25)] hover:bg-sky-800 duration-200" onclick="loadMore()">Load More</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    let baseURL = "<?php echo $baseURL; ?>";
    let imageBaseURL = "<?php echo $imageBaseURL; ?>";
    let apiKey = "<?php echo $apiKey; ?>";
    let sortBy = "<?php echo $sortBy; ?>";
    let page = "<?php echo $page; ?>";
    let minimalVoter = "<?php echo $minimalVoter; ?>";

    // Untuk menyembunyikan notifikasi dan autoload
    $("#autoLoad").hide();
    $("#notification").hide();

    function loadMore(){
        $.ajax({
            url: `${baseURL}/discover/movie?page=${++page}&sort_by=${sortBy}&api_key=${apiKey}&vote_count.gte=${minimalVoter}`,
            type: "get",
            beforeSend: function(){
                $("#autoLoad").show();
            }
        })
        .done(function (response){
            // Hide Loading
            $("#autoLoad").hide();

            //Mengambil dataset Movies
            if(response.results){
                var MoviesDatas = [];

                response.results.forEach(items => {
                    let original_date = items.release_date;
                    let date = new Date(original_date);
                    let moviesYear = date.getFullYear();
                    let moviesID = items.id;
                    let moviesTitle = items.title;
                    let moviesImage = `${imageBaseURL}/w500${items.poster_path}`;
                    let moviesRating = items.vote_average * 10;

                    MoviesDatas.push(`<a href="movie/${moviesID}" class="group">
                            <div class="min-w-[232px] min-h-[428px] bg-zinc-900 drop-shadow-[0_0px_8px_rgba(255,255,255,0.2)] group-hover:drop-shadow-[0_0px_8px_rgba(255,255,255,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                                <div class="overflow-hidden rounded-[32px]">
                                    <img class="w-[full] h-[300px] rounded-[32px] group-hover:scale-105 duration-200" src="${moviesImage}">
                                </div>

                                <span class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none text-white">${moviesTitle}</span>
                                <span class="font-inter text-sm mt-1 text-white">${moviesYear}</span>

                                <div class="flex flex-row mt-1 items-center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18 21H8V8L15 1L16.25 2.25C16.3667 2.36667 16.4627 2.525 16.538 2.725C16.6127 2.925 16.65 3.11667 16.65 3.3V3.65L15.55 8H21C21.5333 8 22 8.2 22.4 8.6C22.8 9 23 9.46667 23 10V12C23 12.1167 22.9873 12.2417 22.962 12.375C22.9373 12.5083 22.9 12.6333 22.85 12.75L19.85 19.8C19.7 20.1333 19.45 20.4167 19.1 20.65C18.75 20.8833 18.3833 21 18 21ZM6 8V21H2V8H6Z" fill="#38B6FF"></path>
                                    </svg>

                                    <span class="font-inter text-sm ml-1 text-white font-bold">${moviesRating}%</span>
                                </div>
                            </div>
                        </a>`);
                });

                // Buat masukin dan join data
                $("#dataWrapper").append(MoviesDatas.join(""));
            }
        })
        .fail(function (jqHXR, ajaxOptions, thrownError){
            $("#autoLoad").hide();

            //Menampilkan Notifikasi
            $("#NotificationMessage").text("There's an error occurred. Please try again!");
            $("#notification").show();

            setTimeout(function(){
                $("#notification").hide();
            }, 3000);
        })
    }

    function changeSort(component){
        if(component.value){
            // Membuat nilai baru
            sortBy = component.value;

            // Menghapus data
            $("#dataWrapper").html("");

            // Reset nilai halaman
            page = 0;

            // Mengambil data
            loadMore();
        }
    }
</script>
@endsection
