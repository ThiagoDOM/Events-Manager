<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    private function getDates()
    {
        if ($this->dt_end) {
            return $this->dt_start . " to " . $this->dt_end;
        } else {
            return $this->dt_start;
        }
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'thumbnail' => $this->thumbnail,
            'dates' => $this->getDates(),
            'created_at' => date('Y-m-d - H:i', strtotime($this->created_at)),
        ];
    }
}
