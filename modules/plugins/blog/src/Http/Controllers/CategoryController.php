<?php

namespace EG\Blog\Http\Controllers;

use EG\Base\Events\BeforeEditContentEvent;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Forms\FormBuilder;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Traits\HasDeleteManyItemsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use EG\Blog\Forms\CategoryForm;
use EG\Blog\Http\Requests\CategoryRequest;
use EG\Blog\Models\Category;
use EG\Blog\Repositories\Interfaces\CategoryInterface;
use EG\Blog\Tables\CategoryTable;
use Exception;

class CategoryController extends BaseController
{
    use HasDeleteManyItemsTrait;
    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(CategoryTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/blog::categories.menu'));

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/blog::categories.create'));

        return $formBuilder->create(CategoryForm::class)->renderForm();
    }

    public function store(CategoryRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
           $this->categoryRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $category = $this->categoryRepository->createOrUpdate(array_merge($request->input(), [
            'author_id' => Auth::user()->getKey(),
        ]));

        event(new CreatedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        return $response
            ->setPreviousUrl(route('categories.index'))
            ->setNextUrl(route('categories.edit', $category->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Request $request, $id, FormBuilder $formBuilder)
    {
        $category = $this->categoryRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $category));

        page_title()->setTitle(trans('plugins/blog::categories.edit') . ' "' . $category->name . '"');

        return $formBuilder->create(CategoryForm::class, ['model' => $category])->renderForm();
    }

    public function update($id, CategoryRequest $request, BaseHttpResponse $response)
    {
        $category = $this->categoryRepository->findOrFail($id);

        if ($request->input('is_default')) {
            $this->categoryRepository->getModel()->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $category->fill($request->input());

        $this->categoryRepository->createOrUpdate($category);

        event(new UpdatedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        return $response
            ->setPreviousUrl(route('categories.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }


    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $category = $this->categoryRepository->findOrFail($id);

            if (!$category->is_default) {
                $this->categoryRepository->delete($category);
                event(new DeletedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));
            }

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->categoryRepository, TAG_MODULE_SCREEN_NAME);
    }

}
