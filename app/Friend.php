<?php

namespace App;

class Friend extends BaseModel
{

  const STATUS = [
    'PENDING' => 1,
    'APPROVED' => 2
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id', 'friend_id', 'status',
  ];

  public function user(){
    return $this->belongsTo('App\User');
  }
}
