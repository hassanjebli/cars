<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarImage extends Model
{
  use HasFactory;

  protected $fillable = [
    'image_path',
    'position',
  ];
  public $timestamps = false;

  public function car(): BelongsTo
  {
    return $this->belongsTo(Car::class);
  }
}
