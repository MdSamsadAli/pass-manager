<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontendController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_list = $user->managers()->paginate(5);
        return view('dashboard', compact('user_list'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'sitename' => 'required',
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        $user = Auth::user();
        $user->managers()->create($request->all());

        return redirect()
            ->route('dashboard')
            ->with('success', 'User Saved successfully!');
    }

    public function edit($id)
    {
        $user_list = Manager::all();
        $single_user = Manager::findorFail($id);
        return view('dashboard', compact('user_list', 'single_user'));
    }

    public function update(Request $request, $id)
    {
        $user = Manager::findOrFail($id);

        $request->validate([
            'sitename' => 'required',
            'username' => 'required',
            'password' => 'nullable',
        ]);

        $data = $request->all();

        // if ($request->password) {
        //     $data['password'] = $request->password;
        // }

        $user->update($data);

        return redirect()->route('dashboard')
            ->with('success', 'User updated successfully!');
    }

    public function delete($id)
    {
        $delete = Manager::find($id);
        if ($delete) {
            $delete->delete();
            return redirect()->route('dashboard')
                ->with('success', 'User deleted successfully!');
        } else {
            return redirect()->route('dashboard')
                ->with('error', 'Something wrong ');
        }
    }

    public function ajaxSearch(Request $request)
    {
        $query = Manager::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('username', 'like', "%{$search}%")
                ->orWhere('sitename', 'like', "%{$search}%");
        }

        $user_list = $query->orderBy('id', 'desc')->get();

        return view('partial_list', compact('user_list'))->render();
    }

    public function bookmarklet(Request $request)
    {
        $site = $request->site;
        $user = Auth::user();
        $items = $user->managers()->get()->map(function ($item) {
            return [
                'username' => $item->sitename,
                'password' => $item->password,
            ];
        });
        // dd($items, $site);
        return view('bookmarklet', compact('items', 'site'));
    }

    public function socialMedia()
    {
        $user = Auth::user();
        $user_list = $user->managers()->paginate(5);
        return view('socialmedia', compact('user_list'));
    }

    public function bankDetails()
    {
        $user = Auth::user();
        $user_list = $user->managers()->paginate(5);
        return view('bankdetails', compact('user_list'));
    }

    public function educationInfo()
    {
        $user = Auth::user();
        $user_list = $user->managers()->paginate(5);
        return view('educationinfo', compact('user_list'));
    }

    public function notes()
    {
        $user = Auth::user();
        $user_list = $user->managers()->paginate(5);
        return view('notes', compact('user_list'));
    }

    public function blogs()
    {
        $user = Auth::user();
        $user_list = $user->managers()->paginate(5);
        return view('blogs', compact('user_list'));
    }

    public function drivingLicence()
    {
        $user = Auth::user();
        $user_list = $user->managers()->paginate(5);
        return view('driving-licence', compact('user_list'));
    }
}
