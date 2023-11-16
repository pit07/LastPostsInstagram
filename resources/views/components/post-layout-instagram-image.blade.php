@php
    use Carbon\Carbon;
@endphp

<a href="{{ $post['permalink'] }}" target="_blank" class="instagram-item">
    <img class="instagram-item-image w-100" src="{{ $post['media_url']}}" alt="">
    <p class="mt-2">{{ $post['caption'] }}</p>
    <i>Posté le {{ Carbon::parse($post['timestamp'])->format('d/m/Y à H:i') }}</i>
</a>
