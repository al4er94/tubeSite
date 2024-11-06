<?php

namespace App\Http\Controllers;

use App\Models\VideoContents;
use App\Models\Categories;
use App\Models\VideoCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Admin extends Controller
{
    public function getAdminPanel()
    {
        if (!Auth::getUser()->isAdmin()) {
            return redirect()->route('home.index');
        }

        return view('admin/dashboard');
    }

    public function getContent()
    {
        $contents =  VideoContents::orderBy('created_at', 'desc')->paginate(15);

        return view('admin/contents', ['contents' => $contents->toArray()]);
    }

    public function getVideoContent (string $id)
    {
        return view('admin/content', [
            'content' => VideoContents::find($id)->toArray(),
            'categories' => Categories::all()->toArray(),
            'categoriesLinking' => VideoCategories::where(VideoCategories::FIELD_VIDEO_ID, '=', $id)
                ->get(VideoCategories::FIELD_CATEGORY_ID)
                ->pluck(VideoCategories::FIELD_CATEGORY_ID)->toArray(),
        ]);
    }

    public function updateVideoContent(Request $request, string $id)
    {
        $categories = $request->filled('category') ? $request->post('category') : [];
        if (!empty($categories)) {
            VideoCategories::where(VideoCategories::FIELD_VIDEO_ID, '=', $id)->delete();
            $update = [];
            foreach ($categories as $category) {
                $update[] = [
                    VideoCategories::FIELD_VIDEO_ID => $id,
                    VideoCategories::FIELD_CATEGORY_ID => $category
                ];
            }

            VideoCategories::insert($update);
        }

        VideoContents::where(VideoContents::FIELD_ID, '=', $id)->update([
            VideoContents::FIELD_NAME => $request->filled('name') ? $request->post('name') : '',
            VideoContents::FIELD_DESCRIPTION => $request->filled('description') ? $request->post('description') : '',
        ]);

        return redirect()->route('content', ['id' => $id]);
    }

    public function getUsers()
    {
        $users = [];

        foreach (User::all() as $user) {
            $users[] = [
                'id' => $user['id'],
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'admin' => $user->isAdmin(),
            ];
        }

        return view('admin/users', ['users' => $users]);
    }

    public function getUser(string $id)
    {
        return view('admin/user', ['user' => User::find($id)]);
    }

    public function updateUser(Request $request, string $id)
    {
        User::where([User::FIELD_ID => $id])->limit(1)->update([
            User::FIELD_NAME => $request->post('name'),
            User::FIELD_EMAIL => $request->post('email'),
            User::FIELD_ADMIN => ($request->filled('is_admin') && $request->post('is_admin') == User::USER_ADMIN ) ? User::USER_ADMIN : User::USER_NOT_ADMIN,
        ]);

        return redirect()->route('user', ['id' => $id]);
    }

    public function getCategories()
    {
        return view('admin/categories', ['categories' => Categories::all()->toArray()]);
    }

    public function getCategory ($id = null)
    {
        return view('admin/category', ['category' => Categories::find($id)->toArray(), 'id' => $id]);
    }

    public function createCategory(Request $request, string $id = '0')
    {
        if ($request->isMethod("GET")) {
            return view('admin/category', ['category' => [], 'id' => 0]);
        }

        if ($id === '0') {
            Categories::insert([
                Categories::FIELD_NAME => $request->filled('name') ? (string) $request->post('name') : '',
                Categories::FIELD_DESCRIPTION => $request->filled('description') ?(string) $request->post('description') : '',
                Categories::FIELD_IMG_URL => $request->filled('img_url') ? (string) $request->post('img_url') : ''
            ]);
        } else {
            Categories::where(Categories::FIELD_ID, '=', $id)->limit(1)->update([
                Categories::FIELD_NAME => $request->filled('name') ? (string) $request->post('name') : '',
                Categories::FIELD_DESCRIPTION => $request->filled('description') ? (string) $request->post('description') : '',
                Categories::FIELD_IMG_URL => $request->filled('img_url') ? (string) $request->post('img_url') : ''
            ]);
        }

        return redirect()->route('categories');
    }
}

