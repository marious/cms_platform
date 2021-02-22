<?php

namespace EG\Blog\Http\Controllers;

use EG\Base\Events\BeforeEditContentEvent;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Forms\FormBuilder;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Traits\HasDeleteManyItemsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use EG\Blog\Forms\PostForm;
use EG\Blog\Http\Requests\PostRequest;
use EG\Blog\Repositories\Interfaces\CategoryInterface;
use EG\Blog\Repositories\Interfaces\PostInterface;
use EG\Blog\Repositories\Interfaces\TagInterface;
use EG\Blog\Services\StoreCategoryService;
use EG\Blog\Services\StoreTagService;
use EG\Blog\Tables\PostTable;
use Exception;

class PostController
{
    use HasDeleteManyItemsTrait;

    /**
     * @var PostInterface
     */
    protected $postRepository;

    /**
     * @var TagInterface
     */
    protected $tagRepository;

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    public function __construct(
        PostInterface $postRepository,
        TagInterface $tagRepository,
        CategoryInterface $categoryRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(PostTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/blog::posts.menu_name'));

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/blog::posts.create'));

        return $formBuilder->create(PostForm::class)->renderForm();
    }

    public function store(
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    )
    {
        $post = $this->postRepository->createOrUpdate(array_merge($request->input(), [
            'author_id' => Auth::user()->getKey(),
        ]));

        event(new CreatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('posts.index'))
            ->setNextUrl(route('posts.edit', $post->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $post = $this->postRepository->findOrFail($id);
        event(new BeforeEditContentEvent($request, $post));
        page_title()->setTitle(trans('plugins/blog::posts.edit') . ' "' . $post->name . '"');

        return $formBuilder->create(PostForm::class, ['model' => $post])->renderForm();
    }

    public function update(
        $id,
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    )
    {
        $post = $this->postRepository->findOrFail($id);
        $post->fill($request->input());
        $this->postRepository->createOrUpdate($post);
        event(new UpdatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));
        $tagService->execute($request, $post);
        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('posts.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy($id, Request $request, BaseHttpResponse $response)
    {
        try {
            $post = $this->postRepository->findOrFail($id);
            $this->postRepository->delete($post);
            event(new DeletedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

            return $response
                ->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $ex) {
            return $response
                    ->settError()
                    ->setMessage($ex->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->postRepository, POST_MODULE_SCREEN_NAME);
    }
}
