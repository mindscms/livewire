<div>
    <form wire:submit.prevent="update" enctype="multipart/form-data" class="pb-5">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" wire:model="title" class="form-control">
                    @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" wire:model="category" class="form-control">
                        <option></option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" class="form-control" wire:model="body" rows="5"></textarea>
            @error('body')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="custom-file" wire:model="image">
            @error('image')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="text-center">
            <input type="submit" name="save" value="Update Post" class="btn btn-primary">
        </div>
    </form>
</div>
