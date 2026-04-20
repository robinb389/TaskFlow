<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Etiquetes</h2>
            <a href="{{ route('tags.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                + Nova etiqueta
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($tags->isEmpty())
                <div class="bg-white rounded-xl border border-gray-200 p-16 text-center text-gray-400">
                    Encara no hi ha etiquetes.
                </div>
            @else
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Color</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hex</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($tags as $tag)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <span class="inline-block w-8 h-8 rounded-full border border-gray-200"
                                              style="background-color: {{ $tag->color }}"></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-3 py-1 rounded-full text-white text-sm font-medium"
                                              style="background-color: {{ $tag->color }}">
                                            {{ $tag->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-400 font-mono">{{ $tag->color }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('tags.edit', $tag) }}" class="text-sm text-gray-500 hover:underline">Editar</a>
                                            <form action="{{ route('tags.destroy', $tag) }}" method="POST"
                                                  onsubmit="return confirm('Eliminar aquesta etiqueta?')">
                                                @csrf @method('DELETE')
                                                <button class="text-sm text-red-500 hover:underline">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
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
