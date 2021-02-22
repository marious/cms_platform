<?php
namespace EG\Blog\Services\Abstracts;

use Illuminate\Http\Request;
use EG\Blog\Models\Post;
use EG\Blog\Repositories\Interfaces\CategoryInterface;

abstract class StoreCategoryServiceAbstract
{
    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    abstract public function execute(Request $request, Post $post);
}
