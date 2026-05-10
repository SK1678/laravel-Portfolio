<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('user_type', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by user type
        if ($request->filled('user_type') && $request->user_type !== 'all') {
            $query->where('user_type', $request->user_type);
        }

        $perPage = $request->input('per_page', 10);
        $users = $query->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            return view('admin.partials.user-table', compact('users'))->render();
        }

        return view('admin.user', compact('users'));
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        // Repair corrupted data if needed
        if ($user->additional_info) {
            $user->additional_info = [
                'personal' => $this->repairMismatchedData($user->additional_info['personal'] ?? []),
                'education' => $this->repairMismatchedData($user->additional_info['education'] ?? []),
                'professional' => $this->repairMismatchedData($user->additional_info['professional'] ?? []),
                'social_links' => $user->additional_info['social_links'] ?? [],
                'cv' => $user->additional_info['cv'] ?? null,
            ];
        }

        return view('admin.user-edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'profile_title' => ['nullable', 'string', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'user_type' => ['required', 'in:admin,user'],
            'is_site_owner' => ['boolean'],
        ]);

        $data = $request->only(['name', 'email', 'profile_title', 'user_type', 'is_site_owner']);
        $data['is_site_owner'] = $request->has('is_site_owner');

        // Handle Image Upload
        if ($request->filled('profile_image_path')) {
            $data['profile_image'] = $request->input('profile_image_path');
        }
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $path = $file->store('profiles', 'public');
            $this->registerMedia($file, $path);
            $data['profile_image'] = $path;
        }

        // Handle Dynamic Education Information
        $educationData = $request->input('education_info', []);
        $education = [];

        foreach ($educationData as $key => $edu) {
            $docs = [];
            
            // Preserve existing docs
            if (isset($edu['existing_docs'])) {
                $docs = array_values($edu['existing_docs']);
                unset($edu['existing_docs']);
            }

            // Handle New Document Uploads or Selections
            $newDocsData = $edu['new_docs'] ?? [];
            $newDocsFiles = $request->file("education_info.{$key}.new_docs", []);
            
            foreach ($newDocsData as $docIdx => $docData) {
                if (isset($newDocsFiles[$docIdx]['file']) && $newDocsFiles[$docIdx]['file']->isValid()) {
                    $file = $newDocsFiles[$docIdx]['file'];
                    $path = $file->store('education_docs', 'public');
                    $this->registerMedia($file, $path);
                    $docs[] = [
                        'name' => $docData['name'] ?? $file->getClientOriginalName(),
                        'path' => $path,
                        'password' => $docData['password'] ?? null
                    ];
                } elseif (!empty($docData['path'])) {
                    $path = $docData['path'];
                    $docs[] = [
                        'name' => $docData['name'] ?? basename($path),
                        'path' => $path,
                        'password' => $docData['password'] ?? null
                    ];
                }
            }
            $edu['documents'] = $docs;
            unset($edu['new_docs']); 
            $education[] = $edu;
        }

        // Handle Professional Information (JSON)
        $professionalData = $request->input('professional_info', []);
        $professional = [];

        foreach ($professionalData as $key => $pro) {
            $docs = [];
            
            // Preserve existing docs
            if (isset($pro['existing_docs'])) {
                $docs = array_values($pro['existing_docs']);
                unset($pro['existing_docs']);
            }

            // Handle New Document Uploads or Selections
            $newDocsData = $pro['new_docs'] ?? [];
            $newDocsFiles = $request->file("professional_info.{$key}.new_docs", []);
            
            foreach ($newDocsData as $docIdx => $docData) {
                if (isset($newDocsFiles[$docIdx]['file']) && $newDocsFiles[$docIdx]['file']->isValid()) {
                    $file = $newDocsFiles[$docIdx]['file'];
                    $path = $file->store('professional_docs', 'public');
                    $this->registerMedia($file, $path);
                    $docs[] = [
                        'name' => $docData['name'] ?? $file->getClientOriginalName(),
                        'path' => $path,
                        'password' => $docData['password'] ?? null
                    ];
                } elseif (!empty($docData['path'])) {
                    $path = $docData['path'];
                    $docs[] = [
                        'name' => $docData['name'] ?? basename($path),
                        'path' => $path,
                        'password' => $docData['password'] ?? null
                    ];
                }
            }
            $pro['documents'] = $docs;
            unset($pro['new_docs']);
            $professional[] = $pro;
        }

        // Handle CV Upload
        $cvData = $user->additional_info['cv'] ?? null;
        if ($request->filled('cv_file_path')) {
            $path = $request->input('cv_file_path');
            $cvData = [
                'name' => basename($path),
                'path' => $path
            ];
        }
        if ($request->hasFile('cv_file') && $request->file('cv_file')->isValid()) {
            $file = $request->file('cv_file');
            $path = $file->store('cv_docs', 'public');
            $this->registerMedia($file, $path);
            $cvData = [
                'name' => $file->getClientOriginalName(),
                'path' => $path
            ];
        }

        $data['additional_info'] = [
            'personal' => array_values($request->input('personal_info', [])),
            'education' => $education,
            'professional' => $professional,
            'social_links' => array_values($request->input('social_links', [])),
            'cv' => $cvData
        ];

        $user->update($data);

        return redirect()->route('user.show', $user->id)->with('success', 'User updated successfully.');
    }

    /**
     * Register a new file in the Media Library.
     */
    private function registerMedia($file, $path)
    {
        $originalName = $file->getClientOriginalName();
        $mime = $file->getMimeType();
        $type = 'document';
        
        if (str_starts_with($mime, 'image/')) $type = 'image';
        elseif (str_starts_with($mime, 'video/')) $type = 'video';
        elseif (str_starts_with($mime, 'audio/')) $type = 'audio';
        elseif (str_starts_with($mime, 'application/pdf')) $type = 'pdf';
        elseif (str_contains($mime, 'zip') || str_contains($mime, 'rar')) $type = 'archive';

        return Media::create([
            'filename' => basename($path),
            'original_name' => $originalName,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $mime,
            'type' => $type,
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Helper to fix data where labels and values were saved in separate array elements.
     */
    private function repairMismatchedData(array $data)
    {
        $repaired = [];
        $temp = [];
        
        foreach ($data as $item) {
            // If it's already a complete pair, keep it
            if (count($item) > 1) {
                if (!empty($temp)) { $repaired[] = $temp; $temp = []; }
                $repaired[] = $item;
                continue;
            }

            // Merge if it's a fragment
            foreach ($item as $key => $value) {
                if (isset($temp[$key])) {
                    $repaired[] = $temp;
                    $temp = [$key => $value];
                } else {
                    $temp[$key] = $value;
                }
            }

            if (isset($temp['label']) && isset($temp['value'])) {
                $repaired[] = $temp;
                $temp = [];
            }
            // For education/pro fragments
            if (isset($temp['degree']) && isset($temp['institution'])) { $repaired[] = $temp; $temp = []; }
            if (isset($temp['role']) && isset($temp['company'])) { $repaired[] = $temp; $temp = []; }
        }
        
        if (!empty($temp)) { $repaired[] = $temp; }
        
        return $repaired;
    }

    /**
     * Approve the user.
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);

        return redirect()->back()->with('success', 'User approved successfully.');
    }

    /**
     * Toggle the user status (enable/disable).
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Don't block yourself
        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'You cannot disable your own account.');
        }

        $newStatus = ($user->status == 'active') ? 'disabled' : 'active';
        $user->update(['status' => $newStatus]);

        $message = ($newStatus == 'active') ? 'User enabled successfully.' : 'User disabled successfully.';
        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove the user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Don't delete yourself
        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
