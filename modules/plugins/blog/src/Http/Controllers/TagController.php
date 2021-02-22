<?php
namespace EG\Blog\Http\Controllers;

use EG\Base\Traits\HasDeleteManyItemsTrait;
use Exception;
use Illuminate\Http\Request;
use EG\Blog\Forms\TagForm;
use EG\Base\Forms\FormBuilder;
use EG\Blog\Tables\TagTable;
use Illuminate\Support\Facades\Auth;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Blog\Http\Requests\TagRequest;
use EG\Base\Events\BeforeEditContentEvent;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Blog\Repositories\Interfaces\TagInterface;

class TagController extends BaseController
{
    use HasDeleteManyItemsTrait;
    /**
     * @var TagInterface
     */
    protected $tagRepository;

     /**
     * @param TagInterface $tagRepository
     */
    public function __construct(TagInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }


    public function index(TagTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/blog::tags.menu'));

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/blog::tags.create'));

        return $formBuilder->create(TagForm::class)->renderForm();
    }


    public function store(TagRequest $request, BaseHttpResponse $response)
    {
        $tag = $this->tagRepository->createOrUpdate(array_merge($request->input(),
            ['author_id' => Auth::user()->getKey()]));
        event(new CreatedContentEvent(TAG_MODULE_SCREEN_NAME, $request, $tag));

        return $response
            ->setPreviousUrl(route('tags.index'))
            ->setNextUrl(route('tags.edit', $tag->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }


    public function edit($id, Request $request, FormBuilder $formBuilder)
    {
        $tag = $this->tagRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $tag));

        page_title()->setTitle(trans('plugins/blog::tags.edit') . ' "' . $tag->name . '"');

        return $formBuilder->create(TagForm::class, ['model' => $tag])->renderForm();
    }


    public function update($id, TagRequest $request, BaseHttpResponse $response)
    {
        $tag = $this->tagRepository->findOrFail($id);
        $tag->fill($request->input());

        $this->tagRepository->createOrUpdate($tag);
        event(new UpdatedContentEvent(TAG_MODULE_SCREEN_NAME, $request, $tag));

        return $response
            ->setPreviousUrl(route('tags.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy($id, Request $request, BaseHttpResponse $response)
    {
        try {
            $tag = $this->tagRepository->findOrFail($id);
            $this->tagRepository->delete($tag);

            event(new DeletedContentEvent(TAG_MODULE_SCREEN_NAME, $request, $tag));

            return $response->setMessage(trans('plugins/blog::tags.deleted'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/blog::tags.cannot_delete'));
        }
    }


    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->tagRepository, TAG_MODULE_SCREEN_NAME);
    }


    public function getAllTags()
    {
        return $this->tagRepository->pluck('name');
    }


}
