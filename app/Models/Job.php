<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{
    use HasFactory;
    protected $table = 'job_listings';
    // protected $fillable = ['employer_id', 'title', 'salary'];
    protected $guarded = [];

    public function employer() {
        return $this->belongsTo(Employer::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, foreignPivotKey: "job_listings_id");
    }

    // public static function all(): array {
    //     return [
    //         [
    //             'id' => 1,
    //             'title' => 'Director',
    //             'salary' => '$50,000'
    //         ],
    //         [
    //             'id' => 2,
    //             'title' => 'Programmer',
    //             'salary' => '$10,000'
    //         ],
    //         [
    //             'id' => 3,
    //             'title' => 'Teacher',
    //             'salary' => '$40,000'
    //         ]
    //     ];
    // }
}