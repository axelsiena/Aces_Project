<div class="px-3 col-12 col-lg-9 mx-auto">
    <div class="row mt-3">
        <div class="col-12">
            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{session('success')}}
                </div>
            @endif

            @if(session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{session('error')}}
            </div>
            @endif
        </div>
    </div>

    <h3 class="my-3">{{__('ui.edit_item')}}</h3>
    <form wire:submit.prevent="update" class="mx-auto">
        
         {{-- container immagini --}}
         <div class="bg-body-tertiary border img-container rounded-3 p-1 d-flex flex-wrap gap-2">
            @if (!$existingImages->count() && empty($newImages))
            <div class="d-block m-auto">
                <button class="btn btn-outline-primary d-flex align-items-center gap-1" onclick="document.getElementById('fileInput').click()" wire:click.prevent>
                    <i class="bi bi-plus-lg fs-4"></i>
                    <div>{{__('ui.upload_img')}}</div>
                </button>
            </div>
            @else

            {{-- immagini --}}
            
            @foreach($existingImages as $image)
            <div>
                <div class="d-block m-auto">
                    <div class="img-preview rounded d-block mx-auto my-1" style="background-image: url({{$image->getUrl(600,600)}}); background-size: cover;">
                        <button type="button" class="btn btn-danger m-1" wire:click="removeExistingImage({{ $image->id }})">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        
                    </div>
                </div>
            </div>
            @endforeach
            
            
            @foreach ($newImages as $key => $newImage)
            <div>
                <div class="d-block m-auto">                    
                    <div class="img-preview rounded d-block mx-auto my-1" style="background-image: url({{$newImage->temporaryUrl()}}); background-size: cover;">
                        <button type="button" class="btn btn-danger m-1" wire:click="removeImage({{$key}})">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>                    
                </div>         
            </div>
            @endforeach
            
            {{-- fine immagini --}}
            <div>

                <div class="d-block m-auto">
                    
                    <div class="img-preview d-flex align-items-center justify-content-center ">                
                        <button class="btn btn-outline-primary d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;" onclick="document.getElementById('fileInput').click()" wire:click.prevent>
                            <i class="bi bi-plus-lg fs-3"></i>
                        </button>
                    </div>                
    
                </div>
            </div>

            @endif
        </div>
        @error('temporary_images')
            <p class="text-danger small ">{{__($message)}}</p>
        @enderror 
        @error('existingImages')
            <p class="text-danger small ">{{__($message)}}</p>
        @enderror
        {{-- fine container --}}
        
       
        <div class="input-group mt-3">            
            <label for="title" class="px-3 input-group-text col-6">{{__('ui.title')}}</label>
            <input type="text" name="title" class="form-control col-6 @error('title') is-invalid @enderror" id="title" placeholder="Most lovely item in the world..." wire:model.blur="title">
            
        </div>
        @error('title') 
            <div class="small text-danger">{{__($message)}}</div>                
        @enderror 

        <div class="input-group mt-3">
            <span class="input-group-text col-6">{{__('ui.describe')}}</span>
            <textarea class="form-control col-6 @error('description') is-invalid @enderror" placeholder="Something amazing..." name="description" wire:model.blur="description"></textarea>
        </div>
        @error('description') 
            <div class="small text-danger">{{__($message)}}</div>                
        @enderror

        <div class="input-group mt-3">
            <label class="px-3 input-group-text col-6" for="category">Category</label>
            <select class="form-select col-6 @error('selectedCategory') is-invalid @enderror" id="category" name="category" wire:model.blur="selectedCategory">
            <option selected>Select a category</option>              
                @foreach(\App\Models\Category::all() as $category)
                    <option value={{$category->id}}>
                        @if (app()->getLocale() == 'it')
                        {{ $category->title_it }}
                        @elseif (app()->getLocale() == 'en')
                            {{ $category->title_en }}
                        @elseif (app()->getLocale() == 'es')
                            {{ $category->title_es }}
                        @else
                            {{ $category->title_en }} 
                        @endif
                    </option>
                @endforeach
            </select>            
        </div>
        @error('selectedCategory') 
            <div class="small text-danger">{{__($message)}}</div>                
        @enderror 

        <div class="input-group mt-3">            
            <label for="price" class="px-3 input-group-text col-6">{{__('ui.price')}}</label>
            <input type="text" name="price" class="form-control col-6 @error('price') is-invalid @enderror" id="price" placeholder="€ 8.99" wire:model.blur="price">
        
        </div>        
        @error('price') 
        <div class="small text-danger">{{__($message)}}</div>                
        @enderror 
        
        {{-- US 5 Button Img --}}
        <div class="input-group mt-3 d-none">
            
            <input id="fileInput" wire:model="temporary_images" type="file" name="images" multiple class="form-control shadow @error('temporary_images.*') is-invalid @enderror" placeholder="Img"/>

        </div>
        
        

              

        {{-- Fine US 5 Button Img --}}
        <button class="btn btn-outline-primary mt-3 col-12" type="submit">{{__('ui.upload')}}</button>

    </form>
</div>
