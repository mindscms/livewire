<div>
    @if($this->image != '')
        <div class="col-12 text-center">
            <img src="{{ asset('assets/images/' . $this->image) }}" alt="{{ $this->title }}" class="img-fluid" style="max-width: 100%;">
        </div>
    @endif

    <div class="col-12 justify-content-center pt-5">
        <h3>{{ $this->title }}</h3>
        <small>{{ $this->category }} || By: {{ $this->user }}</small>

        <p class="pt-5">
            {!! $this->body !!}
        </p>
    </div>
</div>
