<x-app-layout>
    @php($canManageTags = auth()->user()->can('admin'))

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tags</h2>
            @if($canManageTags)
                <a href="{{ route('tags.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                    + New tag
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8" style="max-width: 600px;">
            @if($tags->isEmpty())
                <div class="bg-white rounded-xl border border-gray-200 p-16 text-center text-gray-400">
                    No tags found.
                </div>
            @else
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead class="bg-gray-50">
                            <tr>
                                <th style="width: 80px; padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Color</th>
                                <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Name</th>
                                <th style="width: 100px; padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Hex</th>
                                @if($canManageTags)
                                    <th style="width: 100px; padding: 12px 16px; text-align: right; font-size: 11px; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tags as $tag)
                                <tr style="border-top: 1px solid #f3f4f6;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor=''">
                                    <td style="padding: 12px 16px; vertical-align: middle;">
                                        <span style="display: inline-block; width: 32px; height: 32px; border-radius: 50%; border: 1px solid #e5e7eb; background-color: {{ $tag->color }};"></span>
                                    </td>
                                    <td style="padding: 12px 16px; vertical-align: middle;">
                                        <span style="display: inline-block; border-radius: 9999px; border: 1px solid rgba(0,0,0,0.1); padding: 2px 12px; font-size: 14px; font-weight: 600; background-color: {{ $tag->color }}; color: {{ $tag->text_color }};">
                                            {{ $tag->name }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px 16px; vertical-align: middle; font-size: 13px; color: #9ca3af; font-family: monospace;">
                                        {{ $tag->color }}
                                    </td>
                                    @if($canManageTags)
                                        <td style="padding: 12px 16px; vertical-align: middle; text-align: right;">
                                            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 12px;">
                                                <a href="{{ route('tags.edit', $tag) }}" style="font-size: 13px; color: #6b7280; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Edit</a>
                                                <form action="{{ route('tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Delete this tag?')" style="margin: 0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="font-size: 13px; color: #ef4444; background: none; border: none; cursor: pointer; padding: 0;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $tags->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>