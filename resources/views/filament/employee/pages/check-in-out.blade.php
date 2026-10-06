<x-filament-panels::page>

    {{-- ============================================================
         DATE AND LIVE CLOCK
    ============================================================ --}}
    <x-filament::section>

        <x-slot name="heading">
            {{ now()->format('l, F d, Y') }}
        </x-slot>

        <div
            class="space-y-6 text-center"
            x-data="{
                time: '{{ now()->format('h:i:s A') }}'
            }"
            x-init="
                setInterval(() => {
                    time = new Date().toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });
                }, 1000);
            "
        >

            <div>

                <h1 class="text-xl font-semibold text-gray-600 dark:text-gray-300">
                    Current Time
                </h1>

                <p
                    class="mt-2 text-5xl font-bold text-gray-950 dark:text-white"
                    x-text="time"
                ></p>

            </div>

        </div>

    </x-filament::section>


    {{-- ============================================================
         ATTENDANCE SCHEDULE
    ============================================================ --}}
    <x-filament::section class="mt-1">

        <x-slot name="heading">
            Attendance Schedule
        </x-slot>

        <div
            style="
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1rem;
            "
        >

            {{-- =================================================
                 CHECK-IN SCHEDULE
            ================================================== --}}
            <x-filament::card>

                <div style="text-align: center; padding: 0rem;">

                    <x-filament::icon
                        icon="heroicon-o-arrow-right-on-rectangle"
                        style="
                            width: 3rem;
                            height: 3rem;
                            margin: 0 auto 1rem;
                            color: rgb(34, 197, 94);
                        "
                    />

                    <p
                        style="
                            font-size: 1rem;
                            font-weight: 700;
                            color: rgb(75, 85, 99);
                        "
                    >
                        Check-In Time
                    </p>

                    <p
                        style="
                            margin-top: 0.5rem;
                            font-size: 1.5rem;
                            font-weight: 700;
                            color: rgb(34, 197, 94);
                        "
                    >
                        7:30 AM - 8:15 AM
                    </p>

                    <p
                        style="
                            margin-top: 0.5rem;
                            font-size: 0.875rem;
                            color: rgb(107, 114, 128);
                        "
                    >
                        Available every working day
                    </p>

                </div>

            </x-filament::card>


            {{-- =================================================
                 CHECK-OUT SCHEDULE
            ================================================== --}}
            <x-filament::card>

                <div style="text-align: center; padding: 0rem;">

                    <x-filament::icon
                        icon="heroicon-o-arrow-left-on-rectangle"
                        style="
                            width: 3rem;
                            height: 3rem;
                            margin: 0 auto 1rem;
                            color: rgb(239, 68, 68);
                        "
                    />

                    <p
                        style="
                            font-size: 1rem;
                            font-weight: 700;
                            color: rgb(75, 85, 99);
                        "
                    >
                        Check-Out Time
                    </p>

                    <p
                        style="
                            margin-top: 0.5rem;
                            font-size: 1.5rem;
                            font-weight: 700;
                            color: rgb(239, 68, 68);
                        "
                    >
                        4:45 PM - 5:30 PM
                    </p>

                    <p
                        style="
                            margin-top: 0.5rem;
                            font-size: 0.875rem;
                            color: rgb(107, 114, 128);
                        "
                    >
                        Available every working day
                    </p>

                </div>

            </x-filament::card>

        </div>

    </x-filament::section>


    {{-- ============================================================
         TODAY'S ATTENDANCE
    ============================================================ --}}
    <x-filament::section class="mt-6">

        <x-slot name="heading">
            Today's Attendance
        </x-slot>

        @if ($todayAttendance)

            {{-- =================================================
                 CHECK IN / CHECK OUT CARDS
            ================================================== --}}
            <div
                style="
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 0rem;
                "
            >

                {{-- =================================================
                     CHECK IN
                ================================================== --}}
                <x-filament::card>

                    <div style="text-align: center; padding: 1rem;">

                        <x-filament::icon
                            icon="heroicon-o-arrow-right-on-rectangle"
                            style="
                                width: 3rem;
                                height: 3rem;
                                margin: 0 auto 1rem;
                                color: rgb(34, 197, 94);
                            "
                        />

                        <p
                            style="
                                font-size: 0.875rem;
                                font-weight: 500;
                                color: rgb(128, 107, 107);
                                margin-bottom: 0rem;
                            "
                        >
                            Check In Time
                        </p>

                        <p
                            style="
                                font-size: 1.5rem;
                                font-weight: 700;
                                color: rgb(34, 197, 94);
                            "
                        >
                            {{ $todayAttendance->check_in?->format('h:i A') ?? 'Not Checked In' }}
                        </p>

                    </div>

                </x-filament::card>


                {{-- =================================================
                     CHECK OUT
                ================================================== --}}
                <x-filament::card>

                    <div style="text-align: center; padding: 1rem;">

                        <x-filament::icon
                            icon="heroicon-o-arrow-left-on-rectangle"
                            style="
                                width: 3rem;
                                height: 3rem;
                                margin: 0 auto 1rem;
                                color: rgb(239, 68, 68);
                            "
                        />

                        <p
                            style="
                                font-size: 0.875rem;
                                font-weight: 500;
                                color: rgb(107, 114, 128);
                                margin-bottom: 0.5rem;
                            "
                        >
                            Check Out Time
                        </p>

                        <p
                            style="
                                font-size: 1.5rem;
                                font-weight: 700;
                                color: rgb(239, 68, 68);
                            "
                        >
                            {{ $todayAttendance->check_out?->format('h:i A') ?? 'Not Checked Out' }}
                        </p>

                    </div>

                </x-filament::card>

            </div>


            {{-- =================================================
                 TOTAL WORKING HOURS
            ================================================== --}}
            @if ($todayAttendance->check_in && $todayAttendance->check_out)

                <div class="mt-4">

                    <x-filament::card>

                        <div style="text-align: center; padding: 1rem;">

                            <p
                                style="
                                    font-size: 1.25rem;
                                    font-weight: 700;
                                    color: rgb(107, 114, 128);
                                "
                            >
                                Total Working Hours
                            </p>

                            <p
                                style="
                                    margin-top: 0.5rem;
                                    font-size: 2rem;
                                    font-weight: 700;
                                    color: rgb(59, 130, 246);
                                "
                            >
                                {{ $todayAttendance->check_in
                                    ->diff($todayAttendance->check_out)
                                    ->format('%H:%I:%S') }}
                            </p>

                        </div>

                    </x-filament::card>

                </div>

            @else

                {{-- =================================================
                     WAITING FOR CHECK OUT
                ================================================== --}}
                <div class="mt-4">

                    <x-filament::card>

                        <div style="text-align: center; padding: 1rem;">

                            <x-filament::icon
                                icon="heroicon-o-clock"
                                style="
                                    width: 2.5rem;
                                    height: 2.5rem;
                                    margin: 0 auto 0.75rem;
                                    color: rgb(234, 179, 8);
                                "
                            />

                            <p
                                style="
                                    font-size: 1rem;
                                    font-weight: 900;
                                    color: rgb(107, 114, 128);
                                "
                            >
                                Check-out is available from
                            </p>

                            <p
                                style="
                                    margin-top: 0.5rem;
                                    font-size: 1.5rem;
                                    font-weight: 700;
                                    color: rgb(234, 179, 8);
                                "
                            >
                                4:45 PM - 5:30 PM
                            </p>

                        </div>

                    </x-filament::card>

                </div>

            @endif


        @else

            {{-- =================================================
                 NOT CHECKED IN
            ================================================== --}}
            <x-filament::card>

                <div style="text-align: center; padding: 2rem;">

                    <x-filament::icon
                        icon="heroicon-o-clock"
                        style="
                            width: 3rem;
                            height: 3rem;
                            margin: 0 auto 1rem;
                            color: rgb(156, 163, 175);
                        "
                    />

                    <p
                        style="
                            font-size: 1.125rem;
                            font-weight: 500;
                            color: rgb(107, 114, 128);
                        "
                    >
                        You have not checked in today.
                    </p>

                    <p
                        style="
                            font-size: 0.875rem;
                            color: rgb(156, 163, 175);
                            margin-top: 0.5rem;
                        "
                    >
                        Check-in is available from
                        <strong>7:30 AM to 8:15 AM</strong>.
                    </p>

                </div>

            </x-filament::card>

        @endif

    </x-filament::section>


    {{-- ============================================================
         MONTHLY SUMMARY
    ============================================================ --}}
    <x-filament::section class="mt-6">

        <x-slot name="heading">
            This Month's Summary
        </x-slot>

        <div
            style="
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            "
        >

            {{-- =================================================
                 PRESENT DAYS
            ================================================== --}}
            <x-filament::card>

                <div style="text-align: center; padding: 1rem;">

                    <p
                        style="
                            font-size: 1.125rem;
                            font-weight: 700;
                            color: rgb(107, 114, 128);
                        "
                    >
                        Present Days
                    </p>

                    <p
                        style="
                            margin-top: 0.5rem;
                            font-size: 1.75rem;
                            font-weight: 700;
                            color: rgb(34, 197, 94);
                        "
                    >
                        {{
                            App\Models\Attendance::where(
                                'user_id',
                                auth()->id()
                            )
                            ->whereMonth('date', now()->month)
                            ->whereYear('date', now()->year)
                            ->where('status', 'present')
                            ->count()
                        }}
                    </p>

                </div>

            </x-filament::card>


            {{-- =================================================
                 LATE DAYS
            ================================================== --}}
            <x-filament::card>

                <div style="text-align: center; padding: 1rem;">

                    <p
                        style="
                            font-size: 1.125rem;
                            font-weight: 700;
                            color: rgb(107, 114, 128);
                        "
                    >
                        Late Days
                    </p>

                    <p
                        style="
                            margin-top: 0.5rem;
                            font-size: 1.75rem;
                            font-weight: 700;
                            color: rgb(234, 179, 8);
                        "
                    >
                        {{
                            App\Models\Attendance::where(
                                'user_id',
                                auth()->id()
                            )
                            ->whereMonth('date', now()->month)
                            ->whereYear('date', now()->year)
                            ->where('status', 'late')
                            ->count()
                        }}
                    </p>

                </div>

            </x-filament::card>


            {{-- =================================================
                 ABSENT DAYS
            ================================================== --}}
            <x-filament::card>

                <div style="text-align: center; padding: 1rem;">

                    <p
                        style="
                            font-size: 1.125rem;
                            font-weight: 700;
                            color: rgb(107, 114, 128);
                        "
                    >
                        Absent Days
                    </p>

                    <p
                        style="
                            margin-top: 0.5rem;
                            font-size: 1.75rem;
                            font-weight: 700;
                            color: rgb(239, 68, 68);
                        "
                    >
                        {{
                            App\Models\Attendance::where(
                                'user_id',
                                auth()->id()
                            )
                            ->whereMonth('date', now()->month)
                            ->whereYear('date', now()->year)
                            ->where('status', 'absent')
                            ->count()
                        }}
                    </p>

                </div>

            </x-filament::card>

        </div>

    </x-filament::section>

</x-filament-panels::page>