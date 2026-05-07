<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

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
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        // Handle Dynamic Information (JSON)
        $education = array_values($request->input('education_info', []));
        $allFiles = $request->file('education_info', []);

        foreach ($education as $idx => &$edu) {
            $docs = [];
            
            // Preserve existing docs
            if (isset($edu['existing_docs'])) {
                $docs = array_values($edu['existing_docs']);
                unset($edu['existing_docs']);
            }

            // Handle New Document Uploads
            if (isset($allFiles[$idx]['new_docs'])) {
                $newDocsData = $request->input("education_info.{$idx}.new_docs", []);
                $newDocsFiles = $allFiles[$idx]['new_docs'];
                
                foreach ($newDocsFiles as $docIdx => $fileWrapper) {
                    if (isset($fileWrapper['file']) && $fileWrapper['file']->isValid()) {
                        $file = $fileWrapper['file'];
                        $path = $file->store('education_docs', 'public');
                        $docs[] = [
                            'name' => $newDocsData[$docIdx]['name'] ?? $file->getClientOriginalName(),
                            'path' => $path,
                            'password' => $newDocsData[$docIdx]['password'] ?? null
                        ];
                    }
                }
            }
            $edu['documents'] = $docs;
            unset($edu['new_docs']); // Clean up request data
        }

        // Handle Professional Information (JSON)
        $professional = array_values($request->input('professional_info', []));
        $allProFiles = $request->file('professional_info', []);

        foreach ($professional as $idx => &$pro) {
            // ... (keep existing docs processing) ...
            $docs = [];
            if (isset($pro['existing_docs'])) {
                $docs = array_values($pro['existing_docs']);
                unset($pro['existing_docs']);
            }
            if (isset($allProFiles[$idx]['new_docs'])) {
                $newDocsData = $request->input("professional_info.{$idx}.new_docs", []);
                $newDocsFiles = $allProFiles[$idx]['new_docs'];
                foreach ($newDocsFiles as $docIdx => $fileWrapper) {
                    if (isset($fileWrapper['file']) && $fileWrapper['file']->isValid()) {
                        $file = $fileWrapper['file'];
                        $path = $file->store('professional_docs', 'public');
                        $docs[] = [
                            'name' => $newDocsData[$docIdx]['name'] ?? $file->getClientOriginalName(),
                            'path' => $path,
                            'password' => $newDocsData[$docIdx]['password'] ?? null
                        ];
                    }
                }
            }
            $pro['documents'] = $docs;
            unset($pro['new_docs']);
        }

        // Handle CV Upload
        $cvData = $user->additional_info['cv'] ?? null;
        if ($request->hasFile('cv_file') && $request->file('cv_file')->isValid()) {
            $file = $request->file('cv_file');
            $path = $file->store('cv_docs', 'public');
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
