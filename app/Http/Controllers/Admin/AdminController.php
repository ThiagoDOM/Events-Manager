<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $admins = User::query();
        $admins->admins();
        if ($request->name)
            $admins->where('name', 'LIKE', "%$request->name%");

        return Inertia::render('Admin/Admins/List', [
            'query' => $request->all(),
            'admins' => UserResource::collection(
                $admins->latest()->paginate()->withQueryString()
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admin = new User();

        return Inertia::render('Admin/Admins/Form', [
            'admin' => $admin
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();

        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'admin';
        $admin = User::create($data);

        return Redirect::route('admin.admins.edit', $admin->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = User::findOrFail($id);

        if (!$admin->isAdmin())
            abort(404);

        return Inertia::render('Admin/Admins/Form', [
            'admin' => $admin
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $admin = User::findOrFail($id);

        if (!$admin->isAdmin())
            abort(404);

        $data = $request->all();
        if (!$data['password'])
            unset($data['password']);
        else
            $data['password'] = bcrypt($data['password']);

        $admin->fill($data);

        if ($admin->isDirty('email')) {
            $admin->email_verified_at = null;
        }

        $admin->save();

        return Redirect::route('admin.admins.edit', $admin->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $admin = User::findOrFail($id);
        // $request['id'] = $id;
        // $request['role'] = $admin->role;

        // $request->validate([
        //     'id' => ['required', 'not_in:1'],
        //     'role' => ['required', 'in:admin'],
        // ]);

        if (!$admin->isAdmin() || $admin->id == auth()->user()->id) {

            // return Redirect::back()->with('errors', 'Error adding ad');
            return response()->json([], 401);
        } else {
            $admin->delete();
            // return response()->json('Deleted with success!');
        }
    }
}
