<h1>{{ $news->title }}</h1>

@if ($news->thumbnail){
    <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="">
}

<p>{{ $news->content }}</p>

@endif
