<?php
namespace EG\Blog\Services;

use Illuminate\Http\Request;
use EG\Blog\Models\Post;
use EG\Blog\Services\Abstracts\StoreCategoryServiceAbstract;

class StoreCategoryService extends StoreCategoryServiceAbstract
{
    public function execute(Request $request, Post $post)
    {
        $categories = $request->input('categories');
        if (!empty($categories)) {
            $post->categories()->detach();
            foreach ($categories as $category) {
                $post->categories()->attach($category);
            }
        }
    }
}
