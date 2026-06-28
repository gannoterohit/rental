<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'room_type' => $this->room_type,
            'furnishing_type' => $this->furnishing_type,
            'tenant_type' => $this->tenant_type,
            'amenities' => $this->amenities ?? [],
            'rent' => (float) $this->rent,
            'deposit' => (float) $this->deposit,
            'city' => $this->city,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'photo_url' => $this->photo_url,
            'photo_urls' => $this->photo_urls,
            'video_url' => $this->video ? asset('storage/' . $this->video) : $this->video_url,
            'is_featured' => (bool) $this->is_featured,
            'listing_fee_paid' => (bool) $this->listing_fee_paid,
            'status' => $this->status,
            'owner' => new UserResource($this->whenLoaded('owner')),
            'landmarks' => $this->landmarks ?? [],
            'listing_type' => $this->listing_type,
            'broker_fee' => (float) ($this->broker_fee ?? 0),
            'created_at' => $this->created_at,
        ];
    }
}
