<div>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <b>Posts</b>
                    <a href="javascript:void(0);" wire:click="return_to_posts" class="btn btn-primary btn-sm ml-auto">Posts</a>
                </div>
                <div class="card-body">
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
            </div>
        </div>
    </div>
</div>
