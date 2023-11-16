@php
    use Carbon\Carbon;
@endphp

<a href="{{ $post['permalink'] }}" target="_blank" class="instagram-item">
    <video controls muted class="w-100" poster="{{ $post['thumbnail_url']}}">
        <source src="{{ $post['media_url'] }}" type="video/webm" />
    </video>
    <i>Posté le {{ Carbon::parse($post['timestamp'])->format('d/m/Y à H:i') }}</i>
</a>
