<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\UserPermissionEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\traits\UploadFile;
use App\Models\User;


class UserController extends Controller
{
    use UploadFile;

    public function __construct()
    {
        $this->middleware('permission:users_read')->only('index');
        $this->middleware('permission:users_create')->only('create');
        $this->middleware('permission:users_update')->only(['edit','update']);
        $this->middleware('permission:users_delete')->only('destroy');
    }

    public function index()
    {
        $users = User::search(request()->query('name'))
                ->whereHasRole('admin')->latest()->paginate();
        return view('dashboard.users.index' , compact('users'));
    }
    public function create()
    {
        return view('dashboard.users.create');
    }
    public function store(CreateUserRequest $request)
    {
        $date = $request->safe()->except(['permissions']);
        if($request->hasFile('image'))
            $date['image'] = $this->uploadFile(User::UPLOADS,$request->file('image'));

        $user = User::create($date);
        event(new UserPermissionEvent($user , $request->safe()->only('permissions') ));
        return to_route('dashboard.users.index')->with('success', __('site.added_successfully'));
    }
    public function edit(User $user)
    {
        return view('dashboard.users.edit',compact('user'));
    }
    public function update(UpdateUserRequest $request, User $user)
    {
        $date = $request->safe()->except(['permissions']);
        if($request->hasFile('image')){
            if($user->image != 'default.png') {
                $date['image'] = $this->uploadFile(User::UPLOADS,$request->file('image'),$user->image);
            }else{
                $date['image'] = $this->uploadFile(User::UPLOADS,$request->file('image'));
            }
        }
        $user->update($date);
        $user->syncPermissions( $request->safe()->only('permissions')['permissions']);
        return to_route('dashboard.users.index')->with('success', __('site.updated_successfully'));

    }
    public function destroy(User $user)
    {
        if($user->image != 'default.png')
            $this->removeFile(User::UPLOADS, $user->image);
        $user->delete();
        return to_route('dashboard.users.index')->with('success', __('site.deleted_successfully'));
    }
}
