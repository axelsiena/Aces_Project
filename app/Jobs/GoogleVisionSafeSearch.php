<?php

namespace App\Jobs;

use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class GoogleVisionSafeSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ad_image_id;
    /**
     * Create a new job instance.
     */
    public function __construct($ad_image_id)
    {
        $this->ad_image_id = $ad_image_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $i = Image::find($this->ad_image_id);

        // se l'immagine non viene trovata, termina qui il job
        if(!$i){
            return;
        }

        // recuperiamo l'effettivo file e non il campo del database
        $image = file_get_contents(storage_path('app/public/'.$i->path));

        // utilizziamo putenv in quanto il file delle credenziali è troppo grande per inserirlo direttamente nel file .env
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . base_path('google_credential.json'));

        // apriamo e chiudiamo il collegamento con google vision per controllare l'immagine
        $imageAnnotator = new ImageAnnotatorClient();
        $response = $imageAnnotator->safeSearchDetection($image);
        $imageAnnotator->close();

        // recuperiamo i campi coi propri valori (adult, spoof, ecc)
        $safe = $response->getSafeSearchAnnotation(); 

        // salviamo i valori
        $adult = $safe->getAdult();
        $medical = $safe->getMedical();
        $spoof = $safe->getSpoof();
        $violence = $safe->getViolence();
        $racy = $safe->getRacy();

        // creiamo i semafori in base ai 6 valori
        $likelihoodName = [
            'text-secondary fas fa-circle', // "unknown"
            'text-success fas fa-circle',   // "very unlikely"
            'text-success fas fa-circle',   // "unlikely"
            'text-warning fas fa-circle',   // "possible"
            'text-warning fas fa-circle',   // "likely"
            'text-danger fas fa-circle',    // "very likely"
        ];

        // salviamo le etichette nella nostra immagine
        $i->adult = $likelihoodName[$adult];
        $i->medical = $likelihoodName[$medical];
        $i->spoof = $likelihoodName[$spoof];
        $i->violence = $likelihoodName[$violence];
        $i->racy = $likelihoodName[$racy];

        $i->save();




    }
}
