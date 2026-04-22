@foreach ($news as $item)
    <h2>
        <a href="{{ route('news.show', $item->slug) }}">
            {{ $item->title }}
        </a>
    </h2>
@endforeach
