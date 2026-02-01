<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->route('front.socialmedia')
            ->with('success', 'Password saved successfully!');
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
            'password' => 'nullable|min:6',
        ]);

        $data = $request->all();

        if (empty($request->password)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('front.socialmedia')
            ->with('success', 'Password updated successfully!');
    }

    public function delete($id)
    {
        $delete = Manager::find($id);

        if ($delete) {
            $delete->delete();
            return redirect()->route('front.socialmedia')
                ->with('success', 'Password deleted successfully!');
        } else {
            return redirect()->route('dashboard')
                ->with('error', 'Something went wrong');
        }
    }

    public function ajaxSearch(Request $request)
    {
        $user = Auth::user();
        $query = $user->managers();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('sitename', 'like', "%{$search}%");
            });
        }

        $user_list = $query->orderBy('id', 'desc')->get();

        return view('partial_list', compact('user_list'))->render();
    }

    /**
     * BOOKMARKLET - Show popup with credentials
     */
    public function bookmarklet(Request $request)
    {
        $site = $request->site;

        if (
            $site === '127.0.0.1' ||
            $site === 'localhost' ||
            str_starts_with($site, '127.0.0.1:')
        ) {
            $site = $site;
        } else {
            if (!preg_match('#^https?://#i', $site)) {
                $site = 'https://' . $site . '/';
            } else {
                $site = $site;
            }
        }
        $user = Auth::user();
        $items = $user->managers()->get();
        $items = $user->managers()
            ->where('sitename', $site)
            ->get();
        return view('bookmarklet', compact('items', 'site'));
    }

    /**
     * AUTOFILL HELPER - Return JavaScript
     */
    public function autofillHelper()
    {
        return response()->view('autofill-helper')
            ->header('Content-Type', 'application/javascript')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    // Other methods
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
