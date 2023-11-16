<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BBS Test - Instagram Last Posts</title>

        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


    </head>
    <body>


        <section class="container mt-5">
            <h1>Instagram</h1>
            @php
                $lastPosts = app('App\Http\Controllers\InstagramController')->getLastInstagramPosts();
            @endphp
            @if (!$lastPosts)
                <p>Une erreur s'est produite.</p>
            @else
                <p>Vos {{ env('INSTAGRAM_LIMIT') }} derniers posts.</p>
                <div class="instagram-container">
                    @foreach ($lastPosts as $post)
                        @switch($post['media_type'])
                            @case('IMAGE')
                                @component('components.post-layout-instagram-image', ['post' => $post])
                                @endcomponent
                                @break
                            @case('CAROUSEL_ALBUM')
                                @component('components.post-layout-instagram-carousel', ['post' => $post])
                                @endcomponent
                                @break
                            @case('VIDEO')
                                @component('components.post-layout-instagram-video', ['post' => $post])
                                @endcomponent
                                @break
                        @endswitch
                    @endforeach
                </div>
            @endif
        </section>

    </body>
</html>


