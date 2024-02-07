<?php

namespace App\Livewire;

use App\Models\Ad;
use Livewire\Component;
use App\Models\Category;
use App\Jobs\RemoveFaces;
use App\Jobs\ResizeImage;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Jobs\GoogleVisionLabelImage;
use App\Jobs\GoogleVisionSafeSearch;
use Illuminate\Support\Facades\File;

class CreateAd extends Component
{
    use WithFileUploads;
    
    #[Validate('required')] 
    public $temporary_images;

    public $images = [];
    public $ad;

    #[Validate('required|max:100')] 
    public $title;

    #[Validate('required|exists:categories,id')] 
    public $selectedCategory;
    
    #[Validate('required|numeric|min:0.01|max:99999.99')] 
    public $price;

    #[Validate('required|max:500')] 
    public $description;

    protected $rules = [
        'temporary_images.*' => 'image|max:3000',
    ];

    protected $messages = [
        'temporary_images.required' =>'validation.temporary_images.required',
        'temporary_images.*.max'=>'validation.temporary_images.max',
        'temporary_images.*.image'=>'validation.temporary_images.image',
        'title.required'=>'validation.title.required',
        'description.required'=>'validation.description.required',
        'description.max'=>'validation.description.max',
        'selectedCategory'=>'validation.selectedCategory',
        'price'=>'validation.price',        
    ];

    public function updatedTemporaryImages()
    {
        if ($this->validate([
            'temporary_images.*'=>'required|image|max:3600',
        ])) {
            foreach ($this->temporary_images as $image) {
                $this->images[] = $image; 
            }
        }
    }

    public function removeImage($key)
    {
        if (in_array($key, array_keys($this->images))) {
            unset($this->images[$key]);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function store()
    {
        $this->validate();   
        
        $newAd = Ad::create(
           ['title' => $this->title,
            'category_id' => $this->selectedCategory,
            'price' => $this->price,
            'description' => $this->description,
            'user_id' => auth()->user()->id,
            'is_approved' => false
            ]);

        if(count($this->images)){
            foreach($this->images as $image){
               
                $newFileName = "ads/{$newAd->id}";
                $newImage = $newAd->images()->create(['path'=>$image->store($newFileName, 'public')]);

                RemoveFaces::withChain([
                    new ResizeImage($newImage->path, 600 , 600),
                    new GoogleVisionSafeSearch($newImage->id),
                    new GoogleVisionLabelImage($newImage->id),
                     
                ])->dispatch($newImage->id);
               
            }

            File::deleteDirectory(storage_path('/app/livewire-tmp'));
        }
            
            // pulizia degli input
            $this->title = '';
            $this->selectedCategory = null;
            $this->price = '';
            $this->description = '';
            $this->images = [];
            $this->temporary_images = []; 
            
        

        session()->flash('success', trans('ui.ad_created_success'));
        
        $this->dispatch('formsubmit')->to('notification-button');

    }

    public function render()
    {
        return view('livewire.create-ad');
    }
}
