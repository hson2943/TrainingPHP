<?php

namespace App\Services;

use App\Repositories\Gallery\GalleryRepositoryInterface;

class GalleryService
{
    protected $galleryRepo;

    public function __construct(GalleryRepositoryInterface $galleryRepo)
    {
        $this->galleryRepo = $galleryRepo;
    }
    
    /**
    * Update or create a gallery for a product.
    *
    * @param  int  $productId

    * @param  array  $data
    
    * @return void
    */
    public function updateOrCreate($productId, $data)
    {
        $this->galleryRepo->updateOrCreate($productId, $data);
    }

    /**
    * Delete a gallery by ID.
    *
    * @param  int  $id

    * @return void
    */
    public function destroy($id)
    {
        $this->galleryRepo->destroy($id);
    }

    /**
    * Update the galleries for a product.
    *
    * @param  array  $galleries

    * @param  int  $product_id

    * @return void
    */
    public function updateGallery($galleries, $product_id)
    {
        foreach ($galleries as $image) {
            if ($image->url_image) {
                $this->updateOrCreate($product_id, $image);
            } 
            else {
                if ($image->id) {
                    $this->destroy($image->id);
                }
            }
        }
    }
}
