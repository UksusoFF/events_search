<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Source\DestroySource;
use App\Http\Requests\Admin\Source\IndexSource;
use App\Http\Requests\Admin\Source\StoreSource;
use App\Http\Requests\Admin\Source\UpdateSource;
use App\Models\Source;
use Brackets\AdminListing\Facades\AdminListing;

class SourcesController extends Controller
{
    /**
     * @param \App\Http\Requests\Admin\Source\IndexSource $request
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index(IndexSource $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Source::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'type', 'user_id', 'source', 'map_id', 'map_title', 'map_desc', 'map_image', 'map_date'],

            // set columns to searchIn
            ['id', 'type', 'source', 'map_id', 'map_title', 'map_desc', 'map_image', 'map_date']
        );

        if ($request->ajax()) {
            return ['data' => $data];
        }

        return view('admin.source.index', ['data' => $data]);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.source.create');

        return view('admin.source.create');
    }

    /**
     * @param \App\Http\Requests\Admin\Source\StoreSource $request
     *
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreSource $request)
    {
        // Sanitize input
        $sanitized = $request->validated();

        // Store the Source
        $source = Source::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/sources'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/sources');
    }

    /**
     * @param \App\Models\Source $source
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Source $source)
    {
        $this->authorize('admin.source.show', $source);

        // TODO your code goes here
    }

    /**
     * @param \App\Models\Source $source
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Source $source)
    {
        $this->authorize('admin.source.edit', $source);

        return view('admin.source.edit', [
            'source' => $source,
        ]);
    }

    /**
     * @param \App\Http\Requests\Admin\Source\UpdateSource $request
     * @param \App\Models\Source $source
     *
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateSource $request, Source $source)
    {
        // Sanitize input
        $sanitized = $request->validated();

        // Update changed values Source
        $source->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/sources'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/sources');
    }

    /**
     * @param \App\Http\Requests\Admin\Source\DestroySource $request
     * @param \App\Models\Source $source
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(DestroySource $request, Source $source)
    {
        $source->delete();

        if ($request->ajax()) {
            return response([
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ]);
        }

        return redirect()->back();
    }
}
