@php
    use Carbon\Carbon;
@endphp


<div class="instagram-item">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($post['children'] as $key => $item)
                <div class="carousel-item {{ $key ==  0 ? 'active' : ''  }}">
                    <a href="{{ $post['permalink'] }}" target="_blank">
                        <img class="instagram-item-image w-100" src="{{ $item['media_url'] }}" alt="">
                    </a>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
    </div>
    <p class="mt-2">{{ $post['caption'] }}</p>
    <i>Posté le {{ Carbon::parse($post['timestamp'])->format('d/m/Y à H:i') }}</i>
</div>
