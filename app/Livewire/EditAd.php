<?php

namespace App\Livewire;

use App\Models\Ad;
use App\Models\Image;
use Livewire\Component;
use App\Models\Category;
use App\Jobs\ResizeImage;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EditAd extends Component
{
    use WithFileUploads;
    
    public $ad;

    #[Validate('required_without:existingImages')] 
    public $temporary_images;

    #[Validate('required_without:temporary_images')] 
    public $existingImages = [];

    public $newImages = [];

    
    #[Validate('required|max:100')] 
    public $title;

    #[Validate('required|exists:categories,id')] 
    public $selectedCategory;
    
    #[Validate('required|numeric|min:1.00|max:99999.99')] 
    public $price;

    #[Validate('required|max:500')] 
    public $description;

    protected $rules = [
        'temporary_images.*' => 'image|max:3000',
    ];

    protected $messages = [
        'temporary_images.required_without' => 'validation.temporary_images.required_without',
        'temporary_images.*.max'=>'validation.temporary_images.max',
        'temporary_images.*.image'=>'validation.temporary_images.image',
        'existingImages.required_without' => '',
        'title.required'=>'validation.title.required',
        'description.required'=>'validation.description.required',
        'description.max'=>'validation.description.max',
        'selectedCategory'=>'validation.selectedCategory',
        'price'=>'validation.price',
        
    ];

    public function mount(Request $request){
        
        $this->ad= $request->route()->parameter('ad');
        $this->title = $this->ad->title;
        $this->selectedCategory = $this->ad->category->id;
        $this->price = $this->ad->price;
        $this->description = $this->ad->description;
        $this->existingImages = $this->ad->images;
        
    }    

    public function updatedTemporaryImages()
    {
        if ($this->validate([
            'temporary_images.*'=>'required_without:existingImages|image|max:3000',
        ])) {
            foreach ($this->temporary_images as $image) {
                $this->newImages[] = $image;
            }
        }
    }

    // rimuovi nuove immagini
    public function removeImage($key)
    {
        if (in_array($key, array_keys($this->newImages))) {
            unset($this->newImages[$key]);
        }
    }

    public function removeExistingImage($imageId)
    {
        $image = Image::find($imageId);
        if ($image) {

            $cropUrl = $image->getUrl(600,600);
            // dd(base_path('public'.$cropUrl));
            
            File::delete(storage_path('app/public/'.$image->path));
            File::delete(base_path('public'.$cropUrl));

            $image->delete(); // Elimina il record dal database
        }

        // Aggiorna l'array delle immagini esistenti per riflettere la modifica
        $this->existingImages = $this->ad->images()->get();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $this->validate();     

        $this->ad->title = $this->title;
        $this->ad->description = $this->description;
        $this->ad->price = $this->price;
        $this->ad->category_id = $this->selectedCategory;
        $this->ad->is_accepted = false;
        $this->ad->save();

        // Caricamento delle nuove immagini
        if(count($this->newImages)){
            foreach($this->newImages as $newImage){
                
                $newFileName = "ads/{$this->ad->id}";
                $newImage = $this->ad->images()->create(['path'=>$newImage->store($newFileName, 'public')]);

                dispatch(new ResizeImage($newImage->path, 600 , 600));
            }

            File::deleteDirectory(storage_path('/app/livewire-tmp'));
        }
                       
        return redirect()->route('profile')->with('success', trans('ui.ad_edited_success'));
    
        $this->dispatch('formsubmit')->to('notification-button');
    }

    public function render()
    {
        return view('livewire.edit-ad');
    }
}
