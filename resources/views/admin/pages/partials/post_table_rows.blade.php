@forelse($posts as $index => $post)
<tr>
    <td>#{{ str_pad($post->id, 2, '0', STR_PAD_LEFT) }}</td>
    <td>
        @php 
            $gallery = is_string($post->feature_gallery) ? json_decode($post->feature_gallery, true) : $post->feature_gallery;
            $firstImg = is_array($gallery) && count($gallery) > 0 ? $gallery[0] : null;
            if ($firstImg && !Str::startsWith($firstImg, ['http://', 'https://'])) {
                $path = ltrim($firstImg, '/');
                $firstImg = Str::startsWith($path, 'storage/') ? asset($path) : asset('storage/' . $path);
            }
        @endphp
        @if($firstImg)
            <img src="{{ $firstImg }}" class="thumbnail-img" alt="Thumbnail">
        @else
            <div class="thumbnail-placeholder"><i class="ti ti-photo"></i></div>
        @endif
    </td>
    <td>
        <div class="post-title-text">{{ $post->title }}</div>
        <span class="post-slug">{{ $post->slug }}</span>
    </td>
    <td>
        @if($post->status == 'published')
            <span class="status-published">Published</span>
        @else
            <span class="status-draft">Draft</span>
        @endif
    </td>
    <td class="text-center">
        <div class="action-icons">
            <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="icon-view" title="View"><i class="ti ti-eye"></i></a>
            <a href="{{ route('admin.posts.edit', $post->id) }}" class="icon-edit" title="Edit"><i class="ti ti-edit"></i></a>
            <button type="button" class="icon-delete delete-post" data-id="{{ $post->id }}" data-url="{{ route('admin.posts.destroy', $post->id) }}" title="Delete"><i class="ti ti-trash"></i></button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center py-4 text-muted">No posts found.</td>
</tr>
@endforelse

@if($posts->hasPages())
<tr>
    <td colspan="5">
        <div class="pagination-wrapper ajax-pagination">
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
    </td>
</tr>
@endif
