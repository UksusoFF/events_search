<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\DestroyUser;
use App\Http\Requests\Admin\User\IndexUser;
use App\Http\Requests\Admin\User\StoreUser;
use App\Http\Requests\Admin\User\UpdateUser;
use App\Models\User;
use Brackets\AdminAuth\Facades\Activation;
use Brackets\AdminAuth\Services\ActivationService;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * @param \App\Http\Requests\Admin\User\IndexUser $request
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index(IndexUser $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(User::class)->processRequestAndGet(
            $request,
            [
                'id',
                'email',
                'first_name',
                'last_name',
                'activated',
                'forbidden',
                'language',
            ],
            [
                'id',
                'email',
                'first_name',
                'last_name',
            ]
        );

        if ($request->ajax()) {
            return [
                'data' => $data,
                'activation' => config('admin-auth.activations.enabled'),
            ];
        }

        return view('admin.user.index', [
            'data' => $data,
            'activation' => config('admin-auth.activations.enabled'),
        ]);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.user.create');

        return view('admin.user.create', [
            'activation' => config('admin-auth.activations.enabled'),
            'roles' => Role::all(),
        ]);
    }

    /**
     * @param \App\Http\Requests\Admin\User\StoreUser $request
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreUser $request)
    {
        $user = User::create($request->getModifiedData());

        $user->roles()->sync(collect($request->input('roles', []))->map->id->toArray());

        if ($request->ajax()) {
            return [
                'redirect' => action('Admin\UsersController@index'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect()->action('Admin\UsersController@index');
    }

    /**
     * @param \App\Models\User $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('admin.user.show', $user);

        // TODO your code goes here
    }

    /**
     * @param \App\Models\User $user
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('admin.user.edit', $user);

        $user->load('roles');

        return view('admin.user.edit', [
            'user' => $user,
            'activation' => config('admin-auth.activations.enabled'),
            'roles' => Role::all(),
        ]);
    }

    /**
     * @param \App\Http\Requests\Admin\User\UpdateUser $request
     * @param \App\Models\User $user
     *
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateUser $request, User $user)
    {
        $user->update($request->getModifiedData());

        if ($request->input('roles')) {
            $user->roles()->sync(collect($request->input('roles', []))->map->id->toArray());
        }

        if ($request->ajax()) {
            return [
                'redirect' => action('Admin\UsersController@index'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect()->action('Admin\UsersController@index');
    }

    /**
     * @param \App\Http\Requests\Admin\User\DestroyUser $request
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(DestroyUser $request, User $user)
    {
        $user->delete();

        if ($request->ajax()) {
            return response([
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ]);
        }

        return redirect()->back();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Brackets\AdminAuth\Services\ActivationService $activationService
     * @param \App\Models\User $user
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function resendActivationEmail(Request $request, ActivationService $activationService, User $user)
    {
        if (config('admin-auth.activations.enabled')) {
            $response = $activationService->handle($user);
            if ($response == Activation::ACTIVATION_LINK_SENT) {
                if ($request->ajax()) {
                    return [
                        'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                    ];
                }

                return redirect()->back();
            } else {
                if ($request->ajax()) {
                    return [
                        'message' => trans('brackets/admin-ui::admin.operation.failed'),
                    ];
                }

                return redirect()->back();
            }
        } else {
            if ($request->ajax()) {
                return [
                    'message' => trans('brackets/admin-ui::admin.operation.not_allowed'),
                ];
            }

            return redirect()->back();
        }
    }
}
