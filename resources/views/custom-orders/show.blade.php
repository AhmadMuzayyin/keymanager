@extends('layouts.app')

@section('title', 'Detail Custom Order')
@section('page-title', 'Detail Custom Order')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('custom-orders.index') }}"
                    class="inline-flex items-center text-slate-600 hover:text-indigo-600 transition-colors mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
                <h2 class="text-2xl font-bold text-slate-800">{{ $customOrder->title }}</h2>
                <p class="text-slate-500 font-mono text-sm">{{ $customOrder->order_number }}</p>
            </div>
            <div class="flex gap-2">
                @php
                    $statusColors = [
                        'pending' => 'bg-amber-100 text-amber-700',
                        'reviewed' => 'bg-blue-100 text-blue-700',
                        'quoted' => 'bg-purple-100 text-purple-700',
                        'accepted' => 'bg-indigo-100 text-indigo-700',
                        'in_progress' => 'bg-cyan-100 text-cyan-700',
                        'completed' => 'bg-emerald-100 text-emerald-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                    ];
                    $typeColors = [
                        'android' => 'bg-green-100 text-green-700',
                        'desktop' => 'bg-blue-100 text-blue-700',
                        'web' => 'bg-purple-100 text-purple-700',
                        'other' => 'bg-slate-100 text-slate-700',
                    ];
                @endphp
                <span
                    class="px-4 py-2 rounded-xl text-sm font-semibold {{ $typeColors[$customOrder->project_type] ?? 'bg-slate-100 text-slate-700' }}">
                    {{ $customOrder->project_type_label }}
                </span>
                <span
                    class="px-4 py-2 rounded-xl text-sm font-semibold {{ $statusColors[$customOrder->status] ?? 'bg-slate-100 text-slate-700' }}">
                    {{ $customOrder->status_label }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Deskripsi Project</h3>
                    <div class="prose prose-slate max-w-none text-slate-600">
                        {!! nl2br(e($customOrder->description)) !!}
                    </div>
                </div>

                @if ($customOrder->milestones->count() > 0 || in_array($customOrder->status, ['accepted', 'in_progress', 'completed']))
                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-800">Milestones</h3>
                            <button type="button" onclick="document.getElementById('addMilestoneModal').showModal()"
                                class="text-sm text-indigo-600 hover:text-indigo-700">+ Tambah Milestone</button>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center justify-between text-sm mb-2">
                                <span class="text-slate-600">Progress</span>
                                <span class="font-semibold text-slate-800">{{ $customOrder->progress }}%</span>
                            </div>
                            <div class="w-full h-3 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full transition-all duration-500"
                                    style="width: {{ $customOrder->progress }}%"></div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @foreach ($customOrder->milestones as $milestone)
                                <div class="flex items-start space-x-3 p-4 bg-slate-50 rounded-xl">
                                    <form action="{{ route('custom-orders.milestones.update', $milestone) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="title" value="{{ $milestone->title }}">
                                        <input type="hidden" name="percentage" value="{{ $milestone->percentage }}">
                                        <input type="hidden" name="is_completed"
                                            value="{{ $milestone->is_completed ? '0' : '1' }}">
                                        <button type="submit"
                                            class="mt-1 w-5 h-5 rounded border-2 flex items-center justify-center transition-colors {{ $milestone->is_completed ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300 hover:border-indigo-500' }}">
                                            @if ($milestone->is_completed)
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @endif
                                        </button>
                                    </form>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4
                                                class="font-medium text-slate-800 {{ $milestone->is_completed ? 'line-through text-slate-500' : '' }}">
                                                {{ $milestone->title }}
                                            </h4>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-xs font-medium">
                                                    {{ $milestone->percentage }}%
                                                </span>
                                                <form action="{{ route('custom-orders.milestones.destroy', $milestone) }}"
                                                    method="POST" onsubmit="return confirm('Hapus milestone ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        @if ($milestone->description)
                                            <p class="text-sm text-slate-500 mt-1">{{ $milestone->description }}</p>
                                        @endif
                                        @if ($milestone->completed_at)
                                            <p class="text-xs text-emerald-600 mt-1">Selesai:
                                                {{ $milestone->completed_at->format('d M Y H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Pesan</h3>

                    <div class="space-y-4 max-h-96 overflow-y-auto mb-4">
                        @forelse($customOrder->messages as $message)
                            <div class="flex {{ $message->sender_type === 'admin' ? 'justify-end' : 'justify-start' }}">
                                <div
                                    class="max-w-[80%] {{ $message->sender_type === 'admin' ? 'bg-indigo-500 text-white' : 'bg-slate-100 text-slate-800' }} rounded-2xl px-4 py-3">
                                    <p class="text-sm">{{ $message->message }}</p>
                                    <p
                                        class="text-xs {{ $message->sender_type === 'admin' ? 'text-indigo-200' : 'text-slate-500' }} mt-1">
                                        {{ $message->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-slate-500 py-8">Belum ada pesan</p>
                        @endforelse
                    </div>

                    <form action="{{ route('custom-orders.messages.store', $customOrder) }}" method="POST"
                        class="flex gap-3">
                        @csrf
                        <x-input type="text" name="message" placeholder="Tulis pesan..." required class="flex-1" />
                        <x-button-primary type="submit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </x-button-primary>
                    </form>
                </div>
            </div>

            <div class="space-y-6">
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Client</h3>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($customOrder->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $customOrder->name }}</p>
                                <p class="text-sm text-slate-500">{{ $customOrder->email }}</p>
                            </div>
                        </div>
                        @if ($customOrder->phone)
                            <div class="flex items-center text-sm text-slate-600">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                {{ $customOrder->phone }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Detail Project</h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Budget Range</dt>
                            <dd class="text-slate-800 font-medium">{{ $customOrder->budget_range ?: '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Deadline</dt>
                            <dd class="text-slate-800">{{ $customOrder->deadline?->format('d M Y') ?: '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Dibuat</dt>
                            <dd class="text-slate-800">{{ $customOrder->created_at->format('d M Y') }}</dd>
                        </div>
                        @if ($customOrder->quoted_price)
                            <div class="flex justify-between">
                                <dt class="text-slate-500">Harga Penawaran</dt>
                                <dd class="text-indigo-600 font-bold">Rp
                                    {{ number_format($customOrder->quoted_price, 0, ',', '.') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Update Status</h3>
                    <form action="{{ route('custom-orders.update', $customOrder) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <x-select name="status">
                                <option value="pending" {{ $customOrder->status === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="reviewed" {{ $customOrder->status === 'reviewed' ? 'selected' : '' }}>
                                    Reviewed</option>
                                <option value="quoted" {{ $customOrder->status === 'quoted' ? 'selected' : '' }}>Quoted
                                </option>
                                <option value="accepted" {{ $customOrder->status === 'accepted' ? 'selected' : '' }}>
                                    Accepted</option>
                                <option value="in_progress"
                                    {{ $customOrder->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $customOrder->status === 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="cancelled" {{ $customOrder->status === 'cancelled' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </x-select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Harga Penawaran (Rp)</label>
                            <x-input type="number" name="quoted_price" :value="$customOrder->quoted_price" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Admin</label>
                            <x-textarea name="admin_notes" rows="3">{{ $customOrder->admin_notes }}</x-textarea>
                        </div>
                        <x-button-primary type="submit" class="w-full">Update</x-button-primary>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <dialog id="addMilestoneModal" class="rounded-2xl p-0 w-full max-w-md backdrop:bg-slate-900/50">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-800">Tambah Milestone</h3>
                <button type="button" onclick="document.getElementById('addMilestoneModal').close()"
                    class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('custom-orders.milestones.store', $customOrder) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul</label>
                    <x-input type="text" name="title" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <x-textarea name="description" rows="2"></x-textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Persentase (%)</label>
                    <x-input type="number" name="percentage" min="0" max="100" required />
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('addMilestoneModal').close()"
                        class="px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                    <x-button-primary type="submit">Simpan</x-button-primary>
                </div>
            </form>
        </div>
    </dialog>
@endsection
