<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->when($request->id, $this->description),
            'image' => $this->imagePath,
            'price' => $this->discountedPrice(),
            'discount' => $this->discount,
            'genres' => $this->genres->pluck('name')->implode(', '),
            'authors' => $this->authors->pluck('name')->implode(', '),
           // 'genres' => GenreResource::collection($this::whenLoaded('genres')),
           // 'authors' => AuthorResource::collection($this::whenLoaded('authors')),
        ];
    }
}
