<?php

namespace EG\Block\Http\Controllers;

use EG\Base\Events\BeforeEditContentEvent;
use EG\Base\Forms\FormBuilder;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Traits\HasDeleteManyItemsTrait;
use EG\Block\Forms\BlockForm;
use EG\Block\Http\Requests\BlockRequest;
use EG\Block\Repositories\Interfaces\BlockInterface;
use Illuminate\Http\Request;
use Exception;
use EG\Block\Tables\BlockTable;
use Illuminate\Support\Facades\Auth;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;

class BlockController extends BaseController
{
    use HasDeleteManyItemsTrait;

    /**
     * @var BlockInterface
     */
    protected $blockRepository;

    /**
     * BlockController constructor.
     * @param BlockInterface $blockRepository
     */
    public function __construct(BlockInterface $blockRepository)
    {
        $this->blockRepository = $blockRepository;
    }

    /**
     * @param BlockTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(BlockTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/block::block.menu'));

        return $dataTable->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/block::block.create'));

        return $formBuilder->create(BlockForm::class)->renderForm();
    }

    /**
     * @param BlockRequest $request
     * @return BaseHttpResponse
     */
    public function store(BlockRequest $request, BaseHttpResponse $response)
    {
        $block = $this->blockRepository->getModel();
        $block->fill($request->input());
        $block->user_id = Auth::user()->getKey();
        $block->alias = $this->blockRepository->createSlug($request->input('alias'), null);

        $this->blockRepository->createOrUpdate($block);

        event(new CreatedContentEvent(BLOCK_MODULE_SCREEN_NAME, $request, $block));

        return $response
            ->setPreviousUrl(route('block.index'))
            ->setNextUrl(route('block.edit', $block->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $block = $this->blockRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $block));

        page_title()->setTitle(trans('plugins/block::block.edit') . ' "' . $block->name . '"');

        return $formBuilder->create(BlockForm::class, ['model' => $block])->renderForm();
    }

    /**
     * @param int $id
     * @param BlockRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, BlockRequest $request, BaseHttpResponse $response)
    {
        $block = $this->blockRepository->findOrFail($id);
        $block->fill($request->input());
        $block->alias = $this->blockRepository->createSlug($request->input('alias'), $id);

        $this->blockRepository->createOrUpdate($block);

        event(new UpdatedContentEvent(BLOCK_MODULE_SCREEN_NAME, $request, $block));

        return $response
            ->setPreviousUrl(route('block.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy($id, Request $request, BaseHttpResponse $response)
    {
        try {
            $block = $this->blockRepository->findOrFail($id);
            $this->blockRepository->delete($block);
            event(new DeletedContentEvent(BLOCK_MODULE_SCREEN_NAME, $request, $block));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->blockRepository, BLOCK_MODULE_SCREEN_NAME);
    }
}
