<?php
namespace App\Transformers;
use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract{

    public function transform(Post $post){
        return[
            'id' => $post->email
        ];
    }
}