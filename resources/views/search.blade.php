<div class="w-full h-auto min-h-screen flex flex-col bg-zinc-900">
    @extends('layout.layout')

    @section('title', 'MovieTube')

    @section('content')

    {{-- Search wrapper --}}
    <div class="w-full h-auto min-h-screen">
        <div class="w-full pl-10 lg:pl-20 pr-10 lg:pr-0">
            <div class="relative w-full lg:w-80 mt-10 mb-5 bg-white drop-shadow-[0_0px_4px_rgba(255,255,255,0.25)]">
                <input type="search" id="searchInput" class="block w-full p-8 lg:p-4 pl-12 lg_pl-10 text-2xl lg:text-sm text-white bg-neutral-800 focus:outline-none" placeholder="Search..." required>
            </div>
        </div>

        {{-- Content --}}
        <div class="w-auto pl-28 pr-10 pt-6 pb-10 grid grid-cols-3 lg:grid-cols-5 gap-5" id="dataWrapper">
        </div>

        {{-- Notifikasi JIka terjadi masalah --}}
        <div class="min-w-[250px] p-4 bg-red-700 text-white text-center rounded-lg fixed z-index-10 top-1 right-0 mr-10 mt-5 drop-shadow-lg" id="notification">
            <span id="NotificationMessage"></span>
        </div>

        {{-- Gambar Loading --}}
        <div class="w-full pl-28 pr-10 flex justify-center mb-5" id="autoLoad">
            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                <path fill="#FFF" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                </path>
            </svg>
        </div>
    </div>

</div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        let baseURL = "<?php echo $baseURL; ?>";
        let imageBaseURL = "<?php echo $imageBaseURL; ?>";
        let apiKey = "<?php echo $apiKey; ?>";
        let searchKeyword = "";

        // Untuk menyembunyikan notifikasi dan autoload
        $("#autoLoad").hide();
        $("#notification").hide();

        $("#searchInput").keypress(function(event){
            var key = event.which;
            if(key == 13){
                searchKeyword = $('#searchInput').val();
                if(searchKeyword){
                    search();
                }

                return false;
            }
        });

        function search(){
            $.ajax({
            url: `${baseURL}/search/multi?page=1&api_key=${apiKey}&query=${searchKeyword}`,
            type: "get",
            beforeSend: function(){
                $("#autoLoad").show();

                //Hapus Content
                $("#dataWrapper").html("");
            }
        })

        .done(function (response){
            // Hide Loading
            $("#autoLoad").hide();

            if(response.results){
                var Datas = [];
                response.results.forEach(items => {
                    if(items.media_type == 'movie' || items.media_type == 'tv'){
                        let searchTitle = "";
                        let original_date = "";
                        let detailsURL = "";

                        if(items.media_type == 'movie'){
                            detailsURL = `/movie/${items.id}`;
                            original_date = items.release_date;
                            searchTitle = items.title;
                        } else {
                            detailsURL = `/tv/${items.id}`;
                            original_date = items.first_air_date;
                            searchTitle = items.name;
                        }

                        let date = new Date(original_date);

                        let searchYears = date.getFullYear();
                        let searchImages = items.poster_path ? `${imageBaseURL}/w500${items.poster_path}` : 'https://via.placeholder.com/300x400';
                        let searchRating = items.vote_average * 10;

                        Datas.push(`<a href="${detailsURL}" class="group">
                            <div class="min-w-[232px] min-h-[428px] bg-zinc-900 drop-shadow-[0_0px_8px_rgba(255,255,255,0.2)] group-hover:drop-shadow-[0_0px_8px_rgba(255,255,255,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                                <div class="overflow-hidden rounded-[32px]">
                                    <img class="w-[full] h-[300px] rounded-[32px] group-hover:scale-105 duration-200" src="${searchImages}">
                                </div>

                                <span class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none text-white">${searchTitle}</span>
                                <span class="font-inter text-sm mt-1 text-white">${searchYears}</span>

                                <div class="flex flex-row mt-1 items-center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18 21H8V8L15 1L16.25 2.25C16.3667 2.36667 16.4627 2.525 16.538 2.725C16.6127 2.925 16.65 3.11667 16.65 3.3V3.65L15.55 8H21C21.5333 8 22 8.2 22.4 8.6C22.8 9 23 9.46667 23 10V12C23 12.1167 22.9873 12.2417 22.962 12.375C22.9373 12.5083 22.9 12.6333 22.85 12.75L19.85 19.8C19.7 20.1333 19.45 20.4167 19.1 20.65C18.75 20.8833 18.3833 21 18 21ZM6 8V21H2V8H6Z" fill="#38B6FF"></path>
                                    </svg>

                                    <span class="font-inter text-sm ml-1 text-white font-bold">${searchRating}%</span>
                                </div>
                            </div>
                        </a>`);
                    }
                });

                // Buat masukin dan join data
                $("#dataWrapper").append(Datas.join(""));
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

    </script>

@endsection

