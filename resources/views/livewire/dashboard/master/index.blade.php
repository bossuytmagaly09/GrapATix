<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-[#001E2B]">Master Admin Dashboard</h1>
        <div class="px-4 py-1.5 bg-[#00ED64] text-[#001E2B] rounded-full text-xs font-bold uppercase tracking-wider">
            Platform Overview
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium mb-1">Totaal Organisaties</div>
            <div class="text-3xl font-bold text-[#001E2B]">{{ $organizations->count() }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium mb-1">Totaal Gebruikers</div>
            <div class="text-3xl font-bold text-[#001E2B]">{{ $total_users }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium mb-1">Totaal Events</div>
            <div class="text-3xl font-bold text-[#001E2B]">{{ $total_events }}</div>
        </div>
    </div>

    <!-- Organizations Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h2 class="font-bold text-[#001E2B]">Geregistreerde Organisaties</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
                    <tr>
                        <th class="px-6 py-4">Naam</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4 text-center">Events</th>
                        <th class="px-6 py-4 text-center">Users</th>
                        <th class="px-6 py-4">Gemaakt op</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($organizations as $org)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-[#001E2B]">{{ $org->name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $org->slug }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded-full text-xs font-bold">{{ $org->events_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-purple-50 text-purple-700 px-2.5 py-0.5 rounded-full text-xs font-bold">{{ $org->users_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $org->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
