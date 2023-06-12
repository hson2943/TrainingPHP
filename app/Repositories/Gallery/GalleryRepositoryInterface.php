<?php

namespace App\Repositories\Gallery;

interface GalleryRepositoryInterface
{
    public function destroy($id);

    public function show($id);

    public function updateOrCreate($product_id, $data);
}
