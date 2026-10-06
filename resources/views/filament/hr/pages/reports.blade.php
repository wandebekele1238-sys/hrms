<x-filament-panels::page>

    {{-- ========================================================= --}}
    {{-- PAGE HEADER / FILTERS --}}
    {{-- ========================================================= --}}

    <x-filament::section>

        <x-slot name="heading">

            <div class="flex items-center gap-3">

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-2xl
                           bg-gradient-to-br from-primary-500 to-primary-700
                           shadow-lg shadow-primary-500/20"
                >
                    <x-filament::icon
                        icon="heroicon-o-document-chart-bar"
                        class="h-7 w-7 text-white"
                    />
                </div>

                <div>

                    <div class="text-xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        HR Reports
                    </div>

                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Human Resources Reporting Center
                    </div>

                </div>

            </div>

        </x-slot>

        <x-slot name="description">
            <span class="text-gray-600 dark:text-gray-400">
                Generate and analyze employee, attendance, leave,
                payroll, and performance reports.
            </span>
        </x-slot>


        {{-- ===================================================== --}}
        {{-- FILTER GRID --}}
        {{-- ===================================================== --}}

        <div
            class="rounded-2xl border border-primary-100
                   bg-gradient-to-br from-primary-50/70 via-white to-blue-50/50
                   p-5 shadow-sm
                   dark:border-primary-900/50
                   dark:from-primary-950/30
                   dark:via-gray-900
                   dark:to-blue-950/20"
        >

            <div class="mb-5 flex items-center gap-3">

                <div
                    class="flex h-9 w-9 items-center justify-center rounded-xl
                           bg-primary-100 dark:bg-primary-900/40"
                >
                    <x-filament::icon
                        icon="heroicon-o-funnel"
                        class="h-5 w-5 text-primary-600 dark:text-primary-400"
                    />
                </div>

                <div>

                    <div class="font-bold text-gray-900 dark:text-white">
                        Report Filters
                    </div>

                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        Select the information you want to analyze
                    </div>

                </div>

            </div>


            {{ $this->form }}


            <div
                class="mt-6 flex justify-end border-t border-primary-100 pt-5
                       dark:border-primary-900/50"
            >

                <x-filament::button
                    wire:click="generateReport"
                    icon="heroicon-o-magnifying-glass"
                    size="lg"
                >
                    Generate Report
                </x-filament::button>

            </div>

        </div>

    </x-filament::section>



    {{-- ========================================================= --}}
    {{-- REPORT --}}
    {{-- ========================================================= --}}

    @if ($reportGenerated)

        <div id="attendance-report" class="mt-6">


            {{-- ================================================= --}}
            {{-- PRINT BUTTON --}}
            {{-- ================================================= --}}

            <div class="no-print mb-5 flex justify-end">

                <x-filament::button
                    type="button"
                    color="gray"
                    icon="heroicon-o-printer"
                    x-on:click="window.print()"
                    size="lg"
                >
                    Print Full Report
                </x-filament::button>

            </div>



            {{-- ================================================= --}}
            {{-- REPORT CARD --}}
            {{-- ================================================= --}}

            <div
                class="overflow-hidden rounded-3xl border border-gray-200
                       bg-white shadow-xl
                       dark:border-gray-700 dark:bg-gray-900"
            >


                {{-- ================================================= --}}
                {{-- REPORT HEADER --}}
                {{-- ================================================= --}}

                <div
                    class="relative overflow-hidden
                           bg-gradient-to-r from-primary-700
                           via-primary-600 to-blue-600
                           px-6 py-10 text-white"
                >

                    {{-- Decorative circles --}}
                    <div
                        class="absolute -right-16 -top-20 h-64 w-64
                               rounded-full bg-white/10"
                    ></div>

                    <div
                        class="absolute -bottom-24 -left-16 h-64 w-64
                               rounded-full bg-white/10"
                    ></div>


                    <div class="relative text-center">

                        <div class="text-3xl font-extrabold tracking-wide">
                            Oromia Insurance S.C
                        </div>

                        <div class="mt-2 text-lg font-bold tracking-widest">
                            HUMAN RESOURCES DEPARTMENT
                        </div>

                        <div class="mt-1 text-sm text-white/80">
                            Human Resources Management System
                        </div>


                        <div class="mx-auto mt-6 flex items-center justify-center gap-3">

                            <div class="h-px w-20 bg-white/40"></div>

                            <div
                                class="flex h-10 w-10 items-center justify-center
                                       rounded-xl bg-white/15 backdrop-blur"
                            >

                                <x-filament::icon
                                    icon="heroicon-o-document-chart-bar"
                                    class="h-6 w-6 text-white"
                                />

                            </div>

                            <div class="h-px w-20 bg-white/40"></div>

                        </div>


                        <div class="mt-5 text-2xl font-extrabold">
                            Employee Attendance Report
                        </div>

                        <div class="mt-2 text-sm text-white/80">
                            Attendance Monitoring and Analysis Report
                        </div>

                    </div>

                </div>



                <div class="p-6">


                    {{-- ================================================= --}}
                    {{-- INFORMATION GRID --}}
                    {{-- ================================================= --}}

                    <div class="mb-5 flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl
                                   bg-blue-100 dark:bg-blue-900/30"
                        >

                            <x-filament::icon
                                icon="heroicon-o-information-circle"
                                class="h-5 w-5 text-blue-600 dark:text-blue-400"
                            />

                        </div>

                        <div>

                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                Report Information
                            </div>

                            <div class="text-xs text-gray-500">
                                Selected report criteria
                            </div>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">


                        {{-- Generated --}}
                        <div
                            class="group rounded-2xl border border-blue-200
                                   bg-gradient-to-br from-blue-50 to-white
                                   p-5 shadow-sm
                                   dark:border-blue-900/50
                                   dark:from-blue-950/30
                                   dark:to-gray-900"
                        >

                            <div class="flex items-center justify-between">

                                <div class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                                    Generated Date
                                </div>

                                <x-filament::icon
                                    icon="heroicon-o-calendar-days"
                                    class="h-5 w-5 text-blue-500"
                                />

                            </div>

                            <div class="mt-3 font-bold text-gray-900 dark:text-white">
                                {{ now()->format('F d, Y H:i') }}
                            </div>

                        </div>


                        {{-- From --}}
                        <div
                            class="rounded-2xl border border-violet-200
                                   bg-gradient-to-br from-violet-50 to-white
                                   p-5 shadow-sm
                                   dark:border-violet-900/50
                                   dark:from-violet-950/30
                                   dark:to-gray-900"
                        >

                            <div class="text-xs font-bold uppercase tracking-wider text-violet-600 dark:text-violet-400">
                                From Date
                            </div>

                            <div class="mt-3 font-bold text-gray-900 dark:text-white">

                                {{ ! empty($data['from_date'])
                                    ? \Carbon\Carbon::parse($data['from_date'])->format('F d, Y')
                                    : '-' }}

                            </div>

                        </div>


                        {{-- To --}}
                        <div
                            class="rounded-2xl border border-purple-200
                                   bg-gradient-to-br from-purple-50 to-white
                                   p-5 shadow-sm
                                   dark:border-purple-900/50
                                   dark:from-purple-950/30
                                   dark:to-gray-900"
                        >

                            <div class="text-xs font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400">
                                To Date
                            </div>

                            <div class="mt-3 font-bold text-gray-900 dark:text-white">

                                {{ ! empty($data['to_date'])
                                    ? \Carbon\Carbon::parse($data['to_date'])->format('F d, Y')
                                    : '-' }}

                            </div>

                        </div>


                        {{-- Department --}}
                        <div
                            class="rounded-2xl border border-amber-200
                                   bg-gradient-to-br from-amber-50 to-white
                                   p-5 shadow-sm
                                   dark:border-amber-900/50
                                   dark:from-amber-950/30
                                   dark:to-gray-900"
                        >

                            <div class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">
                                Department
                            </div>

                            <div class="mt-3 font-bold text-gray-900 dark:text-white">

                                @if (! empty($data['department_id']))

                                    {{ \App\Models\Department::find($data['department_id'])?->name ?? '-' }}

                                @else

                                    All Departments

                                @endif

                            </div>

                        </div>


                        {{-- Employee --}}
                        <div
                            class="rounded-2xl border border-emerald-200
                                   bg-gradient-to-br from-emerald-50 to-white
                                   p-5 shadow-sm
                                   dark:border-emerald-900/50
                                   dark:from-emerald-950/30
                                   dark:to-gray-900"
                        >

                            <div class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                                Employee
                            </div>

                            <div class="mt-3 font-bold text-gray-900 dark:text-white">

                                @if (! empty($data['employee_id']))

                                    {{ \App\Models\User::find($data['employee_id'])?->name ?? '-' }}

                                @else

                                    All Employees

                                @endif

                            </div>

                        </div>


                        {{-- Total --}}
                        <div
                            class="rounded-2xl border border-primary-200
                                   bg-gradient-to-br from-primary-50 to-white
                                   p-5 shadow-sm
                                   dark:border-primary-800
                                   dark:from-primary-950/40
                                   dark:to-gray-900"
                        >

                            <div class="text-xs font-bold uppercase tracking-wider text-primary-600 dark:text-primary-400">
                                Total Records
                            </div>

                            <div class="mt-3 text-2xl font-extrabold text-primary-700 dark:text-primary-300">
                                {{ $reportSummary['total'] }}
                            </div>

                        </div>

                    </div>



                    {{-- ================================================= --}}
                    {{-- SUMMARY GRID --}}
                    {{-- ================================================= --}}

                    <div class="mt-10">

                        <div class="mb-5 flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl
                                       bg-primary-100 dark:bg-primary-900/30"
                            >

                                <x-filament::icon
                                    icon="heroicon-o-chart-bar-square"
                                    class="h-5 w-5 text-primary-600 dark:text-primary-400"
                                />

                            </div>

                            <div>

                                <div class="text-lg font-bold text-gray-900 dark:text-white">
                                    Attendance Summary
                                </div>

                                <div class="text-xs text-gray-500">
                                    Attendance performance overview
                                </div>

                            </div>

                        </div>


                        <div class="grid grid-cols-2 gap-4 md:grid-cols-5">


                            {{-- TOTAL --}}
                            <div
                                class="rounded-2xl border border-slate-200
                                       bg-gradient-to-br from-slate-50 to-white
                                       p-5 shadow-sm
                                       dark:border-slate-700
                                       dark:from-slate-900 dark:to-gray-900"
                            >

                                <div class="flex items-center justify-between">

                                    <div class="text-sm font-bold text-slate-600 dark:text-slate-400">
                                        Total
                                    </div>

                                    <div
                                        class="flex h-9 w-9 items-center justify-center
                                               rounded-xl bg-slate-200
                                               dark:bg-slate-800"
                                    >

                                        <x-filament::icon
                                            icon="heroicon-o-clipboard-document-list"
                                            class="h-5 w-5 text-slate-600 dark:text-slate-400"
                                        />

                                    </div>

                                </div>

                                <div class="mt-4 text-3xl font-extrabold text-slate-800 dark:text-white">
                                    {{ $reportSummary['total'] }}
                                </div>

                                <div class="mt-1 text-xs text-slate-500">
                                    Records
                                </div>

                            </div>


                            {{-- PRESENT --}}
                            <div
                                class="rounded-2xl border border-emerald-200
                                       bg-gradient-to-br from-emerald-50 to-white
                                       p-5 shadow-sm
                                       dark:border-emerald-800
                                       dark:from-emerald-950/30
                                       dark:to-gray-900"
                            >

                                <div class="flex items-center justify-between">

                                    <div class="text-sm font-bold text-emerald-700 dark:text-emerald-400">
                                        Present
                                    </div>

                                    <div
                                        class="flex h-9 w-9 items-center justify-center
                                               rounded-xl bg-emerald-100
                                               dark:bg-emerald-900/40"
                                    >

                                        <x-filament::icon
                                            icon="heroicon-o-check-circle"
                                            class="h-5 w-5 text-emerald-600"
                                        />

                                    </div>

                                </div>

                                <div class="mt-4 text-3xl font-extrabold text-emerald-700 dark:text-emerald-400">
                                    {{ $reportSummary['present'] }}
                                </div>

                                <div class="mt-1 text-xs text-emerald-600 dark:text-emerald-500">
                                    On time
                                </div>

                            </div>


                            {{-- LATE --}}
                            <div
                                class="rounded-2xl border border-amber-200
                                       bg-gradient-to-br from-amber-50 to-white
                                       p-5 shadow-sm
                                       dark:border-amber-800
                                       dark:from-amber-950/30
                                       dark:to-gray-900"
                            >

                                <div class="flex items-center justify-between">

                                    <div class="text-sm font-bold text-amber-700 dark:text-amber-400">
                                        Late
                                    </div>

                                    <div
                                        class="flex h-9 w-9 items-center justify-center
                                               rounded-xl bg-amber-100
                                               dark:bg-amber-900/40"
                                    >

                                        <x-filament::icon
                                            icon="heroicon-o-clock"
                                            class="h-5 w-5 text-amber-600"
                                        />

                                    </div>

                                </div>

                                <div class="mt-4 text-3xl font-extrabold text-amber-700 dark:text-amber-400">
                                    {{ $reportSummary['late'] }}
                                </div>

                                <div class="mt-1 text-xs text-amber-600 dark:text-amber-500">
                                    Late arrivals
                                </div>

                            </div>


                            {{-- ABSENT --}}
                            <div
                                class="rounded-2xl border border-rose-200
                                       bg-gradient-to-br from-rose-50 to-white
                                       p-5 shadow-sm
                                       dark:border-rose-800
                                       dark:from-rose-950/30
                                       dark:to-gray-900"
                            >

                                <div class="flex items-center justify-between">

                                    <div class="text-sm font-bold text-rose-700 dark:text-rose-400">
                                        Absent
                                    </div>

                                    <div
                                        class="flex h-9 w-9 items-center justify-center
                                               rounded-xl bg-rose-100
                                               dark:bg-rose-900/40"
                                    >

                                        <x-filament::icon
                                            icon="heroicon-o-x-circle"
                                            class="h-5 w-5 text-rose-600"
                                        />

                                    </div>

                                </div>

                                <div class="mt-4 text-3xl font-extrabold text-rose-700 dark:text-rose-400">
                                    {{ $reportSummary['absent'] }}
                                </div>

                                <div class="mt-1 text-xs text-rose-600 dark:text-rose-500">
                                    Not present
                                </div>

                            </div>


                            {{-- RATE --}}
                            <div
                                class="rounded-2xl border border-indigo-200
                                       bg-gradient-to-br from-indigo-50 to-white
                                       p-5 shadow-sm
                                       dark:border-indigo-800
                                       dark:from-indigo-950/30
                                       dark:to-gray-900"
                            >

                                <div class="flex items-center justify-between">

                                    <div class="text-sm font-bold text-indigo-700 dark:text-indigo-400">
                                        Rate
                                    </div>

                                    <div
                                        class="flex h-9 w-9 items-center justify-center
                                               rounded-xl bg-indigo-100
                                               dark:bg-indigo-900/40"
                                    >

                                        <x-filament::icon
                                            icon="heroicon-o-chart-pie"
                                            class="h-5 w-5 text-indigo-600"
                                        />

                                    </div>

                                </div>

                                <div class="mt-4 text-3xl font-extrabold text-indigo-700 dark:text-indigo-400">
                                    {{ $reportSummary['attendance_rate'] }}%
                                </div>

                                <div class="mt-1 text-xs text-indigo-600 dark:text-indigo-500">
                                    Attendance rate
                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- ================================================= --}}
                    {{-- DETAILS --}}
                    {{-- ================================================= --}}

                    <div class="mt-10">


                        <div class="mb-5 flex items-center justify-between">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-xl
                                           bg-cyan-100 dark:bg-cyan-900/30"
                                >

                                    <x-filament::icon
                                        icon="heroicon-o-table-cells"
                                        class="h-5 w-5 text-cyan-600 dark:text-cyan-400"
                                    />

                                </div>

                                <div>

                                    <div class="text-lg font-bold text-gray-900 dark:text-white">
                                        Attendance Details
                                    </div>

                                    <div class="text-xs text-gray-500">
                                        Detailed employee attendance records
                                    </div>

                                </div>

                            </div>

                        </div>


                        <div
                            class="mb-4 rounded-xl border border-cyan-100
                                   bg-cyan-50 px-5 py-3
                                   text-sm text-cyan-800
                                   dark:border-cyan-900/50
                                   dark:bg-cyan-950/20
                                   dark:text-cyan-300"
                        >

                            Attendance records from

                            <span class="font-bold">
                                {{ ! empty($data['from_date'])
                                    ? \Carbon\Carbon::parse($data['from_date'])->format('F d, Y')
                                    : '-' }}
                            </span>

                            to

                            <span class="font-bold">
                                {{ ! empty($data['to_date'])
                                    ? \Carbon\Carbon::parse($data['to_date'])->format('F d, Y')
                                    : '-' }}
                            </span>

                        </div>


                        {{-- TABLE --}}
                        <div
                            class="overflow-hidden rounded-2xl border border-gray-200
                                   shadow-lg dark:border-gray-700"
                        >

                            <div class="overflow-x-auto">

                                <table class="w-full text-sm">

                                    <thead>

                                        <tr
                                            class="bg-gradient-to-r from-primary-600
                                                   to-blue-600 text-white"
                                        >

                                            <th class="px-4 py-4 text-left font-bold">
                                                No.
                                            </th>

                                            <th class="px-4 py-4 text-left font-bold">
                                                Employee Name
                                            </th>

                                            <th class="px-4 py-4 text-left font-bold">
                                                Employee ID
                                            </th>

                                            <th class="px-4 py-4 text-left font-bold">
                                                Date
                                            </th>

                                            <th class="px-4 py-4 text-left font-bold">
                                                Check In
                                            </th>

                                            <th class="px-4 py-4 text-left font-bold">
                                                Check Out
                                            </th>

                                            <th class="px-4 py-4 text-left font-bold">
                                                Status
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                                        @forelse ($reportData as $index => $row)

                                            <tr
                                                class="transition-all
                                                       odd:bg-white even:bg-gray-50
                                                       hover:bg-primary-50
                                                       dark:odd:bg-gray-900
                                                       dark:even:bg-gray-800/50
                                                       dark:hover:bg-primary-950/30"
                                            >

                                                <td class="px-4 py-4 font-semibold text-gray-400">
                                                    {{ $index + 1 }}
                                                </td>

                                                <td class="px-4 py-4">

                                                    <div class="font-bold text-gray-900 dark:text-white">
                                                        {{ $row['employee'] }}
                                                    </div>

                                                </td>

                                                <td class="px-4 py-4">

                                                    <span
                                                        class="rounded-lg bg-gray-100 px-2.5 py-1
                                                               font-mono text-xs font-semibold
                                                               text-gray-700
                                                               dark:bg-gray-800
                                                               dark:text-gray-300"
                                                    >
                                                        {{ $row['employee_id'] }}
                                                    </span>

                                                </td>

                                                <td class="px-4 py-4 font-medium">
                                                    {{ $row['date'] }}
                                                </td>

                                                <td class="px-4 py-4 font-semibold text-gray-700 dark:text-gray-300">
                                                    {{ $row['check_in'] }}
                                                </td>

                                                <td class="px-4 py-4 font-semibold text-gray-700 dark:text-gray-300">
                                                    {{ $row['check_out'] }}
                                                </td>

                                                <td class="px-4 py-4">


                                                    @if ($row['status'] === 'present')

                                                        <span
                                                            class="inline-flex items-center gap-2
                                                                   rounded-full bg-emerald-100
                                                                   px-3 py-1.5
                                                                   text-xs font-bold
                                                                   text-emerald-700
                                                                   dark:bg-emerald-900/30
                                                                   dark:text-emerald-400"
                                                        >

                                                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                                                            Present

                                                        </span>


                                                    @elseif ($row['status'] === 'late')

                                                        <span
                                                            class="inline-flex items-center gap-2
                                                                   rounded-full bg-amber-100
                                                                   px-3 py-1.5
                                                                   text-xs font-bold
                                                                   text-amber-700
                                                                   dark:bg-amber-900/30
                                                                   dark:text-amber-400"
                                                        >

                                                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>

                                                            Late

                                                        </span>


                                                    @elseif ($row['status'] === 'absent')

                                                        <span
                                                            class="inline-flex items-center gap-2
                                                                   rounded-full bg-rose-100
                                                                   px-3 py-1.5
                                                                   text-xs font-bold
                                                                   text-rose-700
                                                                   dark:bg-rose-900/30
                                                                   dark:text-rose-400"
                                                        >

                                                            <span class="h-2 w-2 rounded-full bg-rose-500"></span>

                                                            Absent

                                                        </span>


                                                    @else

                                                        <span
                                                            class="inline-flex items-center gap-2
                                                                   rounded-full bg-gray-100
                                                                   px-3 py-1.5
                                                                   text-xs font-bold
                                                                   text-gray-700
                                                                   dark:bg-gray-700
                                                                   dark:text-gray-300"
                                                        >

                                                            <span class="h-2 w-2 rounded-full bg-gray-500"></span>

                                                            {{ ucfirst($row['status']) }}

                                                        </span>

                                                    @endif

                                                </td>

                                            </tr>


                                        @empty

                                            <tr>

                                                <td
                                                    colspan="7"
                                                    class="px-4 py-14 text-center"
                                                >

                                                    <div class="flex flex-col items-center">

                                                        <div
                                                            class="flex h-14 w-14 items-center justify-center
                                                                   rounded-2xl bg-gray-100
                                                                   dark:bg-gray-800"
                                                        >

                                                            <x-filament::icon
                                                                icon="heroicon-o-document-magnifying-glass"
                                                                class="h-7 w-7 text-gray-400"
                                                            />

                                                        </div>

                                                        <div class="mt-4 font-bold text-gray-700 dark:text-gray-300">
                                                            No attendance records found
                                                        </div>

                                                        <div class="mt-1 text-sm text-gray-500">
                                                            Try changing the selected filters.
                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>



                    {{-- ================================================= --}}
                    {{-- REPORT NOTES --}}
                    {{-- ================================================= --}}

                    <div
                        class="mt-10 rounded-2xl border border-sky-200
                               bg-gradient-to-r from-sky-50 to-blue-50
                               p-5
                               dark:border-sky-900/50
                               dark:from-sky-950/20
                               dark:to-blue-950/20"
                    >

                        <div class="flex items-start gap-4">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center
                                       rounded-xl bg-sky-100
                                       dark:bg-sky-900/40"
                            >

                                <x-filament::icon
                                    icon="heroicon-o-information-circle"
                                    class="h-5 w-5 text-sky-600 dark:text-sky-400"
                                />

                            </div>

                            <div>

                                <div class="font-bold text-sky-900 dark:text-sky-300">
                                    Report Notes
                                </div>

                                <div class="mt-2 text-sm leading-6 text-sky-800 dark:text-sky-300">
                                    This report is generated from the selected date range,
                                    department, and employee filters.
                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- ================================================= --}}
                    {{-- SIGNATURES --}}
                    {{-- ================================================= --}}

                    <div class="mt-14">

                        <div class="mb-8 text-center">

                            <span
                                class="rounded-full bg-gray-100 px-4 py-2
                                       text-xs font-bold uppercase tracking-widest
                                       text-gray-600
                                       dark:bg-gray-800 dark:text-gray-400"
                            >
                                Authorization
                            </span>

                        </div>


                        <div class="grid grid-cols-1 gap-12 md:grid-cols-3">


                            <div class="text-center">

                                <div class="mb-10 border-b-2 border-gray-300 dark:border-gray-600"></div>

                                <div class="font-bold text-gray-800 dark:text-gray-200">
                                    Prepared By
                                </div>

                                <div class="mt-1 text-sm text-gray-500">
                                    Human Resources
                                </div>

                            </div>


                            <div class="text-center">

                                <div class="mb-10 border-b-2 border-gray-300 dark:border-gray-600"></div>

                                <div class="font-bold text-gray-800 dark:text-gray-200">
                                    Checked By
                                </div>

                                <div class="mt-1 text-sm text-gray-500">
                                    HR Manager
                                </div>

                            </div>


                            <div class="text-center">

                                <div class="mb-10 border-b-2 border-gray-300 dark:border-gray-600"></div>

                                <div class="font-bold text-gray-800 dark:text-gray-200">
                                    Approved By
                                </div>

                                <div class="mt-1 text-sm text-gray-500">
                                    Authorized Officer
                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- ================================================= --}}
                    {{-- FOOTER --}}
                    {{-- ================================================= --}}

                    <div
                        class="mt-12 border-t border-gray-200 pt-5
                               text-center text-xs text-gray-500
                               dark:border-gray-700"
                    >

                        <div class="font-bold">
                            HR Management System
                        </div>

                        <div class="mt-1">
                            Generated on {{ now()->format('F d, Y H:i:s') }}
                        </div>

                        <div class="mt-1 font-semibold uppercase tracking-wider">
                            Confidential HR Document
                        </div>

                    </div>


                </div>

            </div>

        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- PRINT CSS --}}
    {{-- ========================================================= --}}

    <style>

        @media print {

            body * {
                visibility: hidden;
            }

            #attendance-report,
            #attendance-report * {
                visibility: visible;
            }

            #attendance-report {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            #attendance-report table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            #attendance-report th,
            #attendance-report td {
                border: 1px solid #9ca3af !important;
                padding: 7px !important;
            }

            #attendance-report tr {
                page-break-inside: avoid;
            }

            @page {
                size: A4 landscape;
                margin: 12mm;
            }

        }

    </style>


</x-filament-panels::page>
